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

class CreateFestivalController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champs est requis.";

    private const ERROR_MAX_LENGTH_NAME
        = "Le nom du festival ne doit pas dépasser 50 caractères.";

    private const ERROR_MAX_LENGTH_DESCRIPTION
        = "La description du festival ne doit pas dépasser 1 000 caractères.";

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

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festival creation view rendering.
     */
    public function render(): void
    {
        View::render("CreateFestival");
    }

    /**
     * Attempt to create the festival.
     *
     * @param Request $request
     */
    public function createFestival(Request $request): RedirectResponse
    {
        $categoriesIds = array(
            "music"          => "1",
            "theater"        => "2",
            "circus"         => "3",
            "dance"          => "4",
            "film-screening" => "5"
        );

        $checkedCategories = [];

        foreach ($categoriesIds as $category => $id)
        {
            if ($request->getInput($category) !== null)
            {
                $checkedCategories[] = $id;
            }
        }

        $validation = (new Validator($request))
            ->required([
                "name", "description", "beginning_date", "ending_date"
            ], self::ERROR_REQUIRED_FIELD)

            ->maxLength("name", 50, self::ERROR_MAX_LENGTH_NAME)
            ->maxLength("description", 1000, self::ERROR_MAX_LENGTH_DESCRIPTION);

        // if (Festival::hasFestival($request->getInput("name")))
        // {
        //     $validation->addError("nameAlreadyUsed", "name",
        //         ERROR_NAME_ALREADY_USED);
        // }

        if (count($checkedCategories) === 0)
        {
            $validation->addError("noCategorieChecked", "categories",
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
        else if (!$isBeginningDateRequired)
        {
            $validation
                ->futureDate("beginning_date", self::ERROR_START_DATE_IN_PAST);
        }
        else
        {
            $validation
                ->futureDate("ending_date", self::ERROR_END_DATE_IN_PAST);
        }

        // Get the file from the $_FILES superglobal
        $imageFile = $request->getFile("illustration");

        // Check if there is a downloaded file
        if ($imageFile && $imageFile->getError() === UPLOAD_ERR_OK)
        {
            $imageExtension = explode('/', $imageFile->getType())[1];

            if (!in_array($imageExtension, ["png", "jpeg", "gif"]))
            {
                $validation->addError("type", "illustration",
                                      sprintf(self::ERROR_TYPE_NOT_SUPPORTED,
                                              '.' . $imageExtension));
            }
            else
            {
                // Generate a unique file name
                $imageName = uniqid("festival_") . "." . $imageExtension;

                $imageFile->setName($imageName);

                $pathToImageFolder = Storage::getResourcesPath()
                                   . "/Medias/Images/FestivalsUploads/";

                // Create the directory if it doesn't exist
                if (!file_exists($pathToImageFolder)) {
                    mkdir($pathToImageFolder, 0777, true);
                }

                $uploadPath = $pathToImageFolder . $imageName;
                
                // Create a file with the path $uploadPath
                $newFile = fopen($uploadPath, "w") or die("Unable to open file!");

                // Write the content of the uploaded file in the new file
                fwrite($newFile, $imageFile->getContent());

                // Close the new file
                fclose($newFile);
            }
        }

        if (!$validation->hasFailed())
        {
            Festival::create($request->getInput("name"),
                             $request->getInput("description"),
                             $imageName ?? null,
                             $request->getInput("beginning_date"),
                             $request->getInput("ending_date"),
                             $checkedCategories);

            Redirect::route("festivals") // TODO rediriger vers la page du festival (pour pouvoir le modifier)
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
        else
        {
            Redirect::route("createFestival")
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
    }
}