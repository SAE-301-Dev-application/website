<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
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
            ->minLength("firstname", 1, "Le prénom doit contenir au moins 1 caractère.")
            ->maxLength("firstname", 25, "Le prénom doit contenir au plus 25 caractères.")
            ->matches("firstname", "/^[a-zA-ZÀ-ÿ\s\-']{1,25}$/u", "Le prénom doit contenir uniquement des lettres, espaces, apostrophes et tirets.")

            ->minLength("lastname", 1, "Le nom de famille doit contenir au moins 1 caractère.")
            ->matches("lastname", "/^[a-zA-ZÀ-ÿ\s\-']{1,50}$/u", "Le nom de famille doit contenir uniquement des lettres, espaces, apostrophes et tirets.")
            ->maxLength("lastname", 50, "Le nom de famille doit contenir au plus 50 caractères.")

            ->minLength("login", 3, "Le login doit contenir au moins 3 caractères.")
            ->maxLength("login", 25, "Le login doit contenir au plus 25 caractères.")

            ->confirmation("password", "Confirmation du mot de passe échouée. Les deux mots de passe sont différents.")
            ->minLength("password", 8, "Le mot de passe doit contenir au moins 8 caractères.")

            ->minLength("email", 5, "L'adresse e-mail doit contenir au moins 5 caractères.")
            ->email("email", "L'adresse e-mail renseignée n'est pas valide. Elle doit être au format 'exemple@email.fr'.");

        if (!$validation->hasError("email", "maxLength"))
        {
            $emailAlreadyTaken = User::emailAlreadyTaken($request->getInput("email"));

            if ($emailAlreadyTaken)
            {
                $validation->addError("unique",
                    "email",
                    "Cette adresse e-mail est déjà utilisée.");
            }
        }

        if (!$validation->hasError("login", "maxLength"))
        {
            $loginAlreadyTaken = User::loginAlreadyTaken($request->getInput("login"));

            if ($loginAlreadyTaken)
            {
                $validation->addError("unique",
                    "login",
                    "Ce login est déjà utilisé.");
            }
        }

        if (!$validation->hasFailed())
        {
            $hash = Password::hash($request->getInput("password"));

            User::create($request->getInput("lastname"),
                         $request->getInput("firstname"),
                         $request->getInput("email"),
                         $request->getInput("login"),
                         $hash);

            Redirect::route("index")
                ->redirect();
        }
        else
        {
            Redirect::route("register")
                ->withValidator($validation)
                ->withRequest($request)
                ->redirect();
        }
    }
}