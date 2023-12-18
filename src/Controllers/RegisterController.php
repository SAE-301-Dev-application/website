<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Security\Validator;
use MvcLite\Models\User;
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
            ])
            ->confirmation(
                $request->getInput("password"),
                $request->getInput("password_confirmation")
            );

        Debug::dd($validation->hasFailed(), $validation->getErrors());

        $emailAlreadyTaken = User::emailAlreadyTaken($request->getInput("email"));
        $loginAlreadyTaken = User::loginAlreadyTaken($request->getInput("login"));

        $hash = Password::hash($request->getInput("password"));

        User::create($request->getInput("lastname"),
            $request->getInput("firstname"),
            $request->getInput("email"),
            $request->getInput("login"),
            $hash);
    }
}