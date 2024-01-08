<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class ProfileController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis";

    private const ERROR_FIRSTNAME_EXCEEDING_MAX_LENGTH
        = "Votre prénom ne peut pas dépasser "
        . User::FIRSTNAME_MAX_LENGTH
        . " caractères.";

    private const ERROR_FIRSTNAME_NOT_MATCHING_REGEX
        = "Votre prénom doit contenir uniquement des lettres, 
           espaces, apostrophes et tirets.";

    private const ERROR_LASTNAME_EXCEEDING_MAX_LENGTH
        = "Votre nom de famille ne peut pas dépasser "
        . User::LASTNAME_MAX_LENGTH
        . " caractères.";

    private const ERROR_LASTNAME_NOT_MATCHING_REGEX
        = "Votre nom de famille doit contenir uniquement des lettres, 
           espaces, apostrophes et tirets.";

    private const ERROR_LOGIN_TOO_SHORT
        = "Votre login doit avoir "
        . User::LOGIN_MIN_LENGTH
        . " caractères au minimum.";

    private const ERROR_LOGIN_EXCEEDING_MAX_LENGTH
        = "Votre login ne peut avoir plus de "
        . User::LOGIN_MAX_LENGTH
        . " caractères.";

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }   

    public function render(): void
    {
        View::render("Profile");
    }

    public function save(Request $request): RedirectResponse
    {
        $validation = (new Validator($request))
            ->required([
                "firstname", "lastname",
                "login", "email",
            ], self::ERROR_REQUIRED_FIELD)

            ->maxLength("firstname",
                        User::FIRSTNAME_MAX_LENGTH,
                        self::ERROR_FIRSTNAME_EXCEEDING_MAX_LENGTH)
            ->matches("firstname",
                      User::FIRSTNAME_REGEX,
                      self::ERROR_FIRSTNAME_NOT_MATCHING_REGEX)

            ->maxLength("lastname",
                        User::LASTNAME_MAX_LENGTH,
                        self::ERROR_LASTNAME_EXCEEDING_MAX_LENGTH)
            ->matches("lastname",
                User::LASTNAME_REGEX,
                self::ERROR_LASTNAME_NOT_MATCHING_REGEX)

            ->minLength("login",
                        User::LOGIN_MIN_LENGTH,
                        self::ERROR_LOGIN_TOO_SHORT)
            ->maxLength("login",
                User::LOGIN_MAX_LENGTH,
                self::ERROR_LOGIN_EXCEEDING_MAX_LENGTH)
        ;

        return Redirect::route("profile")
            ->withValidator($validation)
            ->redirect();
    }
}