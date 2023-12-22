<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Middlewares\GuestMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class SessionController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function logout(): void
    {
        Session::logout();
        Redirect::route("index");
    }
}