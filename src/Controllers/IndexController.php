<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\GuestMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(GuestMiddleware::class);
    }

    public function redirectionIndex()
    {
        Redirect::route("index");
    }

    public function render(): void
    {
        View::render("Index");
    }

    public function login(Request $request): void
    {
        $validation = (new Validator($request))
            ->required([
                "login", "password",
            ], "Ce champ est requis.");

        if (!$validation->hasFailed()
            && !Session::attemptLogin($request->getInput("login"),
                                      $request->getInput("password")))
        {
            $validation->addError("incorrect", "login", "Informations de connexion incorrectes.");
        }

        if ($validation->hasFailed())
        {
            Redirect::route("index")
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
        else
        {
            Redirect::route("dashboard")
                ->redirect();
        }
    }
}