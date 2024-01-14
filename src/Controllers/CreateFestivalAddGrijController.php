<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
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
        $id = $request->getParameter("festival");

        $festival = Festival::getFestivalById($id);
        $grij = $festival->getGriJWithId();

        View::render("CreateFestivalAddGrij", [
            "grij" => $grij,
            "festival" => $festival
        ]);
    }

    /**
     * Attempt to create the festival.
     *
     * @param Request $request
     */
    public function confirmGriJ(Request $request): RedirectResponse
    {
        $validation = (new Validator($request))
            ->required([
                "beginning_hour", "ending_hour", "pause_value"
            ], self::ERROR_REQUIRED_FIELD)

            ->max("pause_value", 24, self::ERROR_PAUSE_TOO_LONG)
            ->min("pause_value", 0, self::ERROR_PAUSE_TOO_SHORT);
        
        if (!$validation->hasFailed())
        {
            GriJ::create($request->getInput("beginning_hour"),
                         $request->getInput("ending_hour"),
                         $request->getInput("pause_value"),
                         $request->getParameter("festival"));

            Redirect::route("festivals")
                ->redirect();
        }
        else
        {
          Redirect::route("addGrijFestival?festival=" . $request->getParameter("festival"))
              ->withValidator($validation)
              ->withRequest($request)
              ->redirect();
        }
    }

    /**
     * @param string $festivalId
     * @return bool If given festival id corresponds to a festival that current user can manage
     */
    private static function isManageableFestival(string $festivalId): bool
    {
        return Festival::getFestivalById($festivalId)->getOwner()->getId() == Session::getSessionId()
            || Festival::getFestivalById($festivalId)->hasOrganizer(Session::getUserAccount());
    }
}