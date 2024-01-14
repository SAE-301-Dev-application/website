<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
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
     * @return RedirectResponse|true
     */
    public function render(Request $request): RedirectResponse|true
    {

        $id = $request->getParameter("id");

        $spectacle = new Spectacle();


        if (!Spectacle::getSpectacleById($id))
        {
            return Redirect::route("spectacles")
                ->redirect();
        }

        $spectacle = Spectacle::getSpectacleById($id);
        View::render("InformationsSpectacle", [
            "spectacle" => $spectacle
        ]);
        return true;
    }
}