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
use MvcLite\Models\GriJ;

class CreateFestivalAddGrijController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";
        
    private const ERROR_ENDING_BEFORE_BEGINNING_DATE
        = "La date de fin ne peut pas être antérieure à celle de début.";

    private const ERROR_START_DATE_IN_PAST
        = "La date de début est passée. Choisissez-en une dans le futur.";

    private const ERROR_END_DATE_IN_PAST
        = "La date de fin est passée. Choisissez-en une dans le futur.";

    private const ERROR_PAUSE_TOO_LONG
        = "La durée de la pause ne peut pas dépasser 24 heures.";

    private const ERROR_PAUSE_TOO_SHORT
        = "La durée de la pause ne peut pas être négative.";

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festival creation view rendering.
     */
    public function render(Request $request): void
    {

        $id = $request->getParameter("id");

        $festival = new Festival();
        $festival = Festival::getFestivalById($id);
        $grij = GriJ::getGriJByFestivalId($id);

        View::render("CreateFestivalAddGrij", [
            "grij" => $grij,
            "festival" => $festival
        ]);
    }

    /* NON TERMINE */
    /**
     * Attempt to create the festival.
     *
     * @param Request $request
     */
    public function confirmGriJ(Request $request): RedirectResponse
    {

        $validation = (new Validator($request))
            ->required([
                "beginning_date", "ending_date", "pause_value"
            ], self::ERROR_REQUIRED_FIELD)

            ->maxLength("name", 50, self::ERROR_MAX_LENGTH_NAME)
            ->max("pause_value", 24, self::ERROR_PAUSE_TOO_LONG)
            ->min("pause_value", 0, self::ERROR_PAUSE_TOO_SHORT);

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