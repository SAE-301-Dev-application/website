<?php

namespace MvcLite\Middlewares;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;

class AuthMiddleware extends Middleware
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function run(): bool|RedirectResponse
    {
        if (!Session::isLogged())
        {
            return Redirect::route("index")
                ->redirect();
        }

        return parent::run();
    }
}