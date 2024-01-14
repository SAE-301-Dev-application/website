<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Scene;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateSceneController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";

    private const ERROR_MAX_LENGTH_NAME
        = "Le nom ne peut contenir au maximum que 25 caractères.";

    private const ERROR_NAME_ALREADY_TAKEN
        = "Ce nom est déjà utilisé par une autre scène.";

    private const ERROR_NOT_NUMERIC_SEATS_MAX
        = "Le nombre maximal de places doit être un nombre.";

    private const ERROR_ZERO_OR_NEGATIVE_SEATS_MAX
        = "Le nombre de places ne peut pas être négatif ou nul.";

    private const ERROR_NOT_NUMERIC_LONGITUDE
        = "La longitude doit être un nombre décimal.";

    private const ERROR_LONGITUDE_LESS_THAN_MIN
        = "La longitude ne peut pas être inférieure à -90,0.";

    private const ERROR_LONGITUDE_EXCEEDS_MAX
        = "La longitude ne peut pas être supérieure à 90,0.";

    private const ERROR_NOT_NUMERIC_LATITUDE
        = "La latitude doit être un nombre décimal.";

    private const ERROR_LATITUDE_LESS_THAN_MIN
        = "La latitude ne peut pas être inférieure à -90,0.";

    private const ERROR_LATITUDE_EXCEEDS_MAX
        = "La latitude ne peut pas être supérieure à 90,0.";

    private const ERROR_NOT_NUMERIC_SIZE
        = "La taille de la scène doit être un entier.";

    private const ERROR_SIZE_NOT_BETWEEN_MIN_AND_MAX
        = "La taille de la scène doit être comprise entre "
        . self::MIN_SCENE_SIZE
        . " et "
        . self::MAX_SCENE_SIZE
        . ".";

    private const MIN_SCENE_SIZE = 1;

    private const MAX_SCENE_SIZE = 3;

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Scene creation view rendering.
     */
    public function render(): void
    {
        View::render("CreateScene");
    }

    /**
     * Attempts to create a new scene with given inputs.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createScene(Request $request): RedirectResponse
    {
        $validation = (new Validator($request))
            ->required([
                "name", "max_seats",
                "longitude", "latitude",
                "size",
            ], self::ERROR_REQUIRED_FIELD)
            ->maxLength("name", 25, self::ERROR_MAX_LENGTH_NAME)
            ->unique("name",
                     Scene::class,
                     "nom_sc",
                     self::ERROR_NAME_ALREADY_TAKEN)

            ->numeric("max_seats", self::ERROR_NOT_NUMERIC_SEATS_MAX)
            ->min("max_seats", 1, self::ERROR_ZERO_OR_NEGATIVE_SEATS_MAX)

            ->numeric("longitude", self::ERROR_NOT_NUMERIC_LONGITUDE)
            ->min("longitude", -90, self::ERROR_LONGITUDE_LESS_THAN_MIN)
            ->max("longitude", 90, self::ERROR_LONGITUDE_EXCEEDS_MAX)

            ->numeric("latitude", self::ERROR_NOT_NUMERIC_LATITUDE)
            ->min("latitude", -90, self::ERROR_LATITUDE_LESS_THAN_MIN)
            ->max("latitude", 90, self::ERROR_LATITUDE_EXCEEDS_MAX)

            ->numeric("size", self::ERROR_NOT_NUMERIC_SIZE)
            ->between("size",
                      self::MIN_SCENE_SIZE,
                      self::MAX_SCENE_SIZE,
                      self::ERROR_SIZE_NOT_BETWEEN_MIN_AND_MAX);

        if (!$validation->hasFailed())
        {
            Scene::create($request->getInput("name"),
                          $request->getInput("size"),
                          $request->getInput("max_seats"),
                          $request->getInput("latitude"),
                          $request->getInput("longitude"));

            return Redirect::route("festivals");
        }
        else
        {
          return Redirect::route("createScene")
              ->withRequest($request)
              ->withValidator($validation)
              ->redirect();
        }
    }
}