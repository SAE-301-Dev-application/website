<?php

namespace MvcLite\Middlewares;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;

/**
 * This middleware checks the existence of the account to
 * which the user is currently connected.
 *
 * If it is not existing, the user's session is destroyed,
 * and he is redirected to root route.
 *
 * @author belicfr
 */
class ExistingAccountMiddleware extends Middleware
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function run(): bool|RedirectResponse
    {
        if (!Session::getSessionAccount() && Session::isLogged())
        {
            Session::logout();
        }

        return parent::run();
    }
}