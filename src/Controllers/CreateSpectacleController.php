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
use MvcLite\Models\Spectacle;

class CreateSpectacleController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";

    private const ERROR_MAX_LENGTH_TITLE
        = "Le titre du spectacle ne doit pas dépasser 50 caractères.";

    private const ERROR_MAX_LENGTH_DESCRIPTION
        = "La description du spectacle ne doit pas dépasser 1000 caractères.";

    private const ERROR_TITLE_ALREADY_USED
        = "Ce titre de spectacle est déjà utilisé.";

    private const ERROR_NEGATIVE_DURATION
        = "La durée du spectacle doit être positive.";

    private const ERROR_MAX_DURATION
        = "La durée du spectacle doit être inférieure à 1680 minutes.";

    /** Accepted scene sizes. */
    private const SCENE_SIZES = [
        "small", "medium", "large"
    ];

    private const ERROR_SCENE_SIZE_NOT_SUPPORTED
        = "La taille de la scène n'est pas supportée.";

    private const ERROR_NO_CATEGORY_CHECKED
        = "Aucune catégorie n'a été renseignée pour ce spectacle. "
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
        "png", "gif", "jpeg"
    ];

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Spectacle creation view rendering.
     */
    public function render(): void
    {
        View::render("CreateSpectacle");
    }

    /**
     * Attempt to create the spectacle.
     *
     * @param Request $request
     */
    public function createSpectacle(Request $request): RedirectResponse
    {
        $categoriesIds = array(
            "music"          => "1",
            "theater"        => "2",
            "circus"         => "3",
            "dance"          => "4",
            "film_screening" => "5"
        );

        $checkedCategories = [];

        foreach ($categoriesIds as $category => $id)
        {
            if ($request->getInput($category) !== null)
            {
                $checkedCategories[] = $id;
            }
        }

        $imageFile = $request->getFile("illustration")->asImage();

        $validation = (new Validator($request))
            ->required([
                "title", "description", "duration", "scene_size"
            ], self::ERROR_REQUIRED_FIELD)

            ->maxLength("title", 50, self::ERROR_MAX_LENGTH_TITLE)
            ->maxLength("description", 1000, self::ERROR_MAX_LENGTH_DESCRIPTION)
            
            ->in("scene_size", self::SCENE_SIZES, self::ERROR_SCENE_SIZE_NOT_SUPPORTED);

        if (!$validation->hasError("duration", "required"))
        {
            $validation
                ->min("duration", 1, self::ERROR_NEGATIVE_DURATION)
                ->max("duration", 1680, self::ERROR_MAX_DURATION);
        }

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

        if (count($checkedCategories) === 0)
        {
            $validation->addError("noCategoryChecked", "categories",
                self::ERROR_NO_CATEGORY_CHECKED);
        }

        if (!$validation->hasFailed()
            && Spectacle::isTitleAlreadyTaken($request->getInput("title")))
        {
            $validation->addError("titleAlreadyUsed", "title",
                self::ERROR_TITLE_ALREADY_USED);
        }

        if (!$validation->hasFailed())
        {
            if ($imageFile && $imageFile->getError() === UPLOAD_ERR_OK)
            {
                // Generate a unique file name
                $imageName = uniqid("spectacle_") . "." . $imageExtension;

                $imageFile->setName($imageName);

                $uploadPath = Storage::createImage($imageFile, "SpectaclesUploads");
            }

            Spectacle::create($request->getInput("title"),
                              $request->getInput("description"),
                              $imageName ?? null,
                              $request->getInput("duration"),
                              $request->getInput("scene_size"),
                              $checkedCategories);

            Redirect::route("dashboard") // TODO rediriger vers la page du spectacle (pour pouvoir le modifier)
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
        else
        {
            Redirect::route("createSpectacle")
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
    }
}