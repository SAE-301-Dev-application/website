<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MVCLite\Router\Engine\Request;
use MVCLite\Router\Engine\RedirectResponse;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;

class ModifyFestivalController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";

    private const ERROR_MAX_LENGTH_NAME
        = "Le nom du festival ne doit pas dépasser 50 caractères.";

    private const ERROR_MAX_LENGTH_DESCRIPTION
        = "La description du festival ne doit pas dépasser 1000 caractères.";

    private const ERROR_NAME_ALREADY_USED
        = "Ce nom de festival est déjà utilisé.";
        
    private const ERROR_ENDING_BEFORE_BEGINNING_DATE
        = "La date de fin ne peut pas être antérieure à celle de début.";

    private const ERROR_START_DATE_IN_PAST
        = "La date de début est passée. Choisissez-en une dans le futur.";

    private const ERROR_END_DATE_IN_PAST
        = "La date de fin est passée. Choisissez-en une dans le futur.";

    private const ERROR_NO_CATEGORY_CHECKED
        = "Aucune catégorie n'a été renseignée pour ce festival. "
        . "Veuillez en choisir une.";

    private const ERROR_TYPE_NOT_SUPPORTED
        = "Le type d'illustration %s n'est pas supporté.";

    private const ERROR_DISRESPECTED_ILLUSTRATION_MAX_SIZE
        = "L'illustration ne peut pas avoir une dimension plus grande que "
        . self::ILLUSTRATION_MAX_WIDTH
        . 'x'
        . self::ILLUSTRATION_MAX_HEIGHT
        . ".";

    private const ILLUSTRATION_MAX_WIDTH = 800;

    private const ILLUSTRATION_MAX_HEIGHT = 600;

    /** Accepted illustration file types. */
    private const ILLUSTRATION_TYPES = [
        "png", "gif", "jpeg",
    ];

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festival creation view rendering.
     */
    public function render(Request $request): RedirectResponse|true
    {
        $id = $request->getParameter("id");

        if ($id === null)
        {
            Redirect::route("festivals")
                ->redirect();
        }

        $festival = Festival::getFestivalById($id);

        if ($festival === null)
        {
            Redirect::route("festivals")
                ->redirect();
        }

        View::render("ModifyFestival", [
            "festival" => $festival
        ]);

        return true;
    }

    /**
     * Attempt to create the festival.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function modifyFestival(Request $request): RedirectResponse
    {
        $categoriesIds = [
            "music"          => "1",
            "theater"        => "2",
            "circus"         => "3",
            "dance"          => "4",
            "film_screening" => "5"
        ];

        $checkedCategories = [];

        foreach ($categoriesIds as $category => $id)
        {
            if ($request->getInput($category) !== null)
            {
                $checkedCategories[] = $id;
            }
        }

        $festival = Festival::getFestivalById($request->getInput("id"));

        if ($festival === null)
        {
            return Redirect::route("festivals")
                ->redirect();
        }

        $imageFile = $request
            ->getFile("illustration")
            ->asImage();

        $validation = (new Validator($request))
            ->required([
                "name", "description", "beginning_date", "ending_date"
            ], self::ERROR_REQUIRED_FIELD)

            ->maxLength("name", 50, self::ERROR_MAX_LENGTH_NAME)
            ->maxLength("description", 1000, self::ERROR_MAX_LENGTH_DESCRIPTION);

        if ($imageFile && $imageFile->getError() === UPLOAD_ERR_OK)
        {
            $imageExtension = explode('/', $imageFile->getType())[1];

            $illustrationWrongTypeErrorMessage = sprintf(
                self::ERROR_TYPE_NOT_SUPPORTED,
                '.' . $imageExtension
            );

            $validation
                ->extension("illustration",
                            self::ILLUSTRATION_TYPES,
                            $illustrationWrongTypeErrorMessage)
                ->maxSize("illustration",
                          self::ILLUSTRATION_MAX_WIDTH,
                          self::ILLUSTRATION_MAX_HEIGHT,
                          self::ERROR_DISRESPECTED_ILLUSTRATION_MAX_SIZE);
        }

        if (!count($checkedCategories))
        {
            $validation->addError("noCategoryChecked", "categories",
                self::ERROR_NO_CATEGORY_CHECKED);
        }

        $isBeginningDateRequired
            = $validation->hasError("beginning_date", "required");

        $isEndingDateRequired
            = $validation->hasError("ending_date", "required");

        if (!$isBeginningDateRequired && !$isEndingDateRequired)
        {
            $validation
                ->dateSlot("beginning_date", "ending_date",
                    self::ERROR_ENDING_BEFORE_BEGINNING_DATE);
        }
        
        if (!$isBeginningDateRequired)
        {
            $validation
                ->futureDate("beginning_date", self::ERROR_START_DATE_IN_PAST);
        }
        
        if (!$isEndingDateRequired)
        {
            $validation
                ->futureDate("ending_date", self::ERROR_END_DATE_IN_PAST);
        }

        if (!$validation->hasFailed())
        {
            if ($imageFile && $imageFile->getError() === UPLOAD_ERR_OK)
            {
                // Generate a unique file name
                $imageName = uniqid("festival_") . "." . $imageExtension;

                $imageFile->setName($imageName);

                $uploadPath = Storage::createImage($imageFile, "FestivalsUploads");
            }


            $festival->modifyGeneralParameters($request->getInput("name"),
                                               $request->getInput("description"),
                                               $imageName ?? null,
                                               $request->getInput("beginning_date"),
                                               $request->getInput("ending_date"),
                                               $checkedCategories);

            return Redirect::to("/informations-festival?id=" . $request->getInput("id"))
                ->redirect();
        }
        else
        {
            return Redirect::to("/modify-festival?id=" . $request->getInput("id"))
                ->withRequest($request)
                ->withValidator($validation)
                ->redirect();
        }
    }
}