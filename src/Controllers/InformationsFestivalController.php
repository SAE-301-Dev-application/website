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
use MvcLite\Models\GriJ;

class InformationsFestivalController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festivals display view rendering.
     * 
     * @param Request $request
     */
    public function render(Request $request): RedirectResponse|true
    {

        $id = $request->getParameter("id");


        if (!Festival::getFestivalById($id))
        {
            return Redirect::route("festivals")
                ->redirect();
        }
        $festival = Festival::getFestivalById($id);

        View::render("InformationsFestival", [
            "festival" => $festival,
        ]);

        return true;
    }
}