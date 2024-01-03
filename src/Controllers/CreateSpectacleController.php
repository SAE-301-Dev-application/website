<?php

namespace MvcLite\Controllers;

use MVCLite\Router\Engine\Request;
use MVCLite\Router\Engine\RedirectResponse;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class CreateSpectacleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }
    
    public function render(): void
    {
        View::render("CreateSpectacle");
    }

    public function createSpectacle(Request $request): RedirectResponse
    {
        echo "ehehe";
    }
}