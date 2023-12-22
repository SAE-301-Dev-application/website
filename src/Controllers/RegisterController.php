<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Security\Validator;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class RegisterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    /**
     * Index view rendering.
     */
    public function render(): void
    {
        View::render("Register");
    }

    /**
     * Attempt to create the account.
     *
     * @param Request $request
     */
    public function register(Request $request): void
    {
        $validation = (new Validator($request))
            ->required([
                "firstname", "lastname", "email",
                "login", "password", "password_confirmation"
            ], "Ce champ est requis.")
            ->confirmation("password", "Les mots de passe ne correspondent pas.");

        $emailAlreadyTaken = User::emailAlreadyTaken($request->getInput("email"));
        $loginAlreadyTaken = User::loginAlreadyTaken($request->getInput("login"));

        if ($emailAlreadyTaken)
        {
            $validation->addError("unique",
                                  "email",
                                  "Cette adresse e-mail est déjà utilisée.");
        }

        if ($loginAlreadyTaken)
        {
            $validation->addError("unique",
                                  "login",
                                  "Ce login est déjà utilisé.");
        }

        if (!$validation->hasFailed())
        {
            $hash = Password::hash($request->getInput("password"));

            User::create($request->getInput("lastname"),
                         $request->getInput("firstname"),
                         $request->getInput("email"),
                         $request->getInput("login"),
                         $hash);
        }

        Redirect::route("register")
            ->withValidator($validation)
            ->redirect();
    }
}