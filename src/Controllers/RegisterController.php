<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Security\Validator;
use MvcLite\Middlewares\GuestMiddleware;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class RegisterController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(GuestMiddleware::class);
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
        $hasFilledRequiredFields = (new Validator())
            ->required($request->getInputs());

        if (!$hasFilledRequiredFields)
        {
            echo "You have not filled all required inputs.";
            die;
        }

        $samePasswords = $request->getInput("password")
                         == $request->getInput("password_confirmation");

        $loginOrEmailAlreadyTaken = User::emailAlreadyTaken($request->getInput("email"))
                                    || User::loginAlreadyTaken($request->getInput("login"));

        if (!$samePasswords)
        {
            echo "Passwords must be the same.";
            die;
        }

        if ($loginOrEmailAlreadyTaken)
        {
            echo "Login or email already taken.";
            die;
        }

        $hash = Password::hash($request->getInput("password"));

        User::create($request->getInput("firstname"),
                     $request->getInput("lastname"),
                     $request->getInput("email"),
                     $request->getInput("login"),
                     $hash);
    }
}