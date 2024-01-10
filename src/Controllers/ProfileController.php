<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Festival;
use MvcLite\Models\Spectacle;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class ProfileController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";

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

    private const ERROR_EMAIL_TOO_SHORT
        = "Votre adresse e-mail doit avoir "
        . User::EMAIL_MIN_LENGTH
        . " caractères au minimum.";

    private const ERROR_EMAIL_EXCEEDING_MAX_LENGTH
        = "Votre adresse e-mail ne peut avoir plus de "
        . User::EMAIL_MAX_LENGTH
        . " caractères.";

    private const ERROR_EMAIL_SYNTAX
        = "L'adresse e-mail renseignée n'est pas valide. 
           Elle doit être au format 'exemple@email.fr'.";

    private const ERROR_WRONG_PASSWORD
        = "Mot de passe incorrect.";

    private const ERROR_TOO_SHORT_PASSWORD
        = "Votre nouveau mot de passe doit avoir "
        . User::PASSWORD_MIN_LENGTH
        . " caractères au minimum.";

    private const ERROR_NEW_PASSWORD_CONFIRMATION
        = "Les nouveaux mots de passe ne correspondent pas.";

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Profile view rendering.
     */
    public function render(): void
    {
        View::render("Profile", [
            "myFestivals" => self::getUserFestivals(),
            "mySpectacles" => self::getUserSpectacles(),
        ]);
    }

    /**
     * Current account general information saving:
     *  - firstname
     *  - lastname
     *  - login
     *  - email address
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveGeneralInformation(Request $request): RedirectResponse
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

            ->minLength("email",
                        User::EMAIL_MIN_LENGTH,
                        self::ERROR_EMAIL_TOO_SHORT)
            ->maxLength("email",
                        User::EMAIL_MAX_LENGTH,
                        self::ERROR_EMAIL_EXCEEDING_MAX_LENGTH)
            ->email("email", self::ERROR_EMAIL_SYNTAX);

        if (!$validation->hasFailed())
        {
            $user = User::getUserById(Session::getSessionId());

            $user->setFirstname($request->getInput("firstname"));
            $user->setLastname($request->getInput("lastname"));
            $user->setLogin($request->getInput("login"));
            $user->setEmail($request->getInput("email"));

            $user->save();
        }

        return Redirect::route("profile")
            ->withValidator($validation)
            ->redirect();
    }

    /**
     * Current account password changing.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function saveNewPassword(Request $request): RedirectResponse
    {
        $validation = (new Validator($request))
            ->required([
                "current_password", "new_password",
                "new_password_confirmation",
            ], self::ERROR_REQUIRED_FIELD)

            ->password("current_password", self::ERROR_WRONG_PASSWORD)

            ->minLength("new_password",
                        User::PASSWORD_MIN_LENGTH,
                        self::ERROR_TOO_SHORT_PASSWORD)
            ->confirmation("new_password",
                           self::ERROR_NEW_PASSWORD_CONFIRMATION);

        if (!$validation->hasFailed())
        {
            $newPassword = Password::hash($request->getInput("new_password"));

            $user = Session::getUserAccount();

            $user->setPassword($newPassword);

            $user->save();
        }

        return Redirect::route("profile")
            ->withValidator($validation)
            ->redirect();
    }

    public function deleteSpectacle(Request $request): RedirectResponse
    {
        $spectacleId = $request->getParameter("spectacleId");
        $spectacle = Spectacle::getSpectacleById($spectacleId);
        $isMySpectacle = true;  // TODO STUB

        if ($spectacleId !== null && $spectacle !== null && $isMySpectacle)
        {
            $spectacle->delete();
        }

        return Redirect::route("profile")
            ->redirect();
    }

    /**
     * Current account deletion confirmation.
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function confirmDeleteAccount(Request $request): void
    {
        $validation = (new Validator($request))
            ->required([
                "password_verification",
            ], self::ERROR_REQUIRED_FIELD)

            ->password("password_verification", self::ERROR_WRONG_PASSWORD);
        
        if ($validation->hasFailed())
        {
            echo ($validation->getError("password_verification", "required")
                  ?? $validation->getError("password_verification", "password"));
        }
        else
        {
            $user = Session::getUserAccount();
    
            //$user->delete();

            echo "success";
        }
        return;
    }

    /**
     * @return array Session user's festivals
     */
    private static function getUserFestivals(): array
    {
        return Festival::queryToArray(Session::getUserAccount()->getFestivals());
    }

    /**
     * @return array Session user's spectacles
     */
    private static function getUserSpectacles(): array
    {
        return Spectacle::queryToArray(Session::getUserAccount()->getSpectacles());
    }
}