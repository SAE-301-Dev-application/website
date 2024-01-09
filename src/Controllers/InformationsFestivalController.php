<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;

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
    public function render(Request $request): void
    {
        // $nom = $request->getParameter("nom");

        $id = $request->getParameter("id");

        $festival = new Festival();
        $festival = Festival::getFestivalById($id);

        Debug::dd($festival, $id); 

        $name = $festival->getName();
        $description = $festival->getDescription();
        $categories = $festival->getCategories();
        $beginningDate = $festival->getBeginningDate();
        $endingDate = $festival->getEndingDate();
        $illustration = $festival->getIllustration();
        $spectacles = $festival->getSpectacles();
        $scenes = $festival->getScenes();
        $utilisateurs = $festival->getUtilisateurs();
        
        View::render("InformationsFestival", [
            "name" => $name,
            "description" => $description,
            "categories" => $categories,
            "beginningDate" => $beginningDate,
            "endingDate" => $endingDate,
            "illustration" => $illustration,
            "spectacles" => $spectacles,
            "scenes" => $scenes,
            "utilisateurs" => $utilisateurs
        ]);
    }
}