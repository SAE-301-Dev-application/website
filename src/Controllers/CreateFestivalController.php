<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MVCLite\Router\Engine\Request;
use MVCLite\Router\Engine\RedirectResponse;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class CreateFestivalController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function render(): void
    {
        View::render("CreateFestival");
    }

    public function createFestival(Request $request): RedirectResponse
    {
        echo "ehehe";
        // Debug::dd($request);
        // $validation = (new Validator($request))
        //     ->required(["name", "description",
        //             "beginning_date","ending_date"],
        //             "Ce champ est requis.")
        // ->minLength("name", 1, "Le nom doit contenir au moins 1 caractère.")
        // ->minLength("description", 1, "La description doit contenir au moins 1 caractère.")
        // ->dateSuperiorTodayDate("beginning_date", "La date de commencement du festival doit être supérieur ou égal à celle du d'aujourd'hui")
        // ->dateSuperior("beginning_date", "ending_date", "La date de fin du festival doit être supérieur ou égal à celle du commencement");

        // var_dump($request);
    }
}