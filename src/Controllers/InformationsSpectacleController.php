<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;
use MvcLite\Models\Spectacle;

class InformationsSpectacleController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Spectacles display view rendering.
     * 
     * @param Request $request
     */
    public function render(Request $request): void
    {

        $id = $request->getParameter("id");

        $spectacle = new Spectacle();
        $spectacle = Spectacle::getSpectacleById($id);
        
        View::render("InformationsSpectacle", [
            "spectacle" => $spectacle
        ]);
    }
}