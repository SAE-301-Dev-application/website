<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Models\Festival;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Request;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class GeneratePlanificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festival creation view rendering.
     * 
     * @param Request $request
     */
    public function render(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if ($festivalId === null || !is_numeric($festivalId)
            || Festival::getFestivalById($festivalId) === null) {
            Redirect::route("festivals")
                ->redirect();
        }
        else
        {
            View::render("GeneratePlanification", [
                "id" => $festivalId
            ]);
        }
    }

    /**
     * Get festival's GriJ and send it (ajax request).
     * 
     * @param Request $request
     */
    public function getGrij(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if ($festivalId === null || !is_numeric($festivalId)) {
            echo "error, id = " . $festivalId ?? "null";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);

        if (!$festival) {
            echo "error, festival is null";
            return;
        }
        
        $grij = Festival::getGrij($festival->getId());

        echo json_encode($grij);
    }

    /**
     * Get festival's spectacles and send it (ajax request).
     * 
     * @param Request $request
     */
    public function getSpectacles(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if ($festivalId === null || !is_numeric($festivalId)) {
            echo "error, id = " . $festivalId ?? "null";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);

        if (!$festival) {
            echo "error, festival is null";
            return;
        }
        
        $spectacles = $festival->getSpectacles();
        
        echo json_encode($spectacles);
    }

    /**
     * Get festival's scenes and send it (ajax request).
     * 
     * @param Request $request
     */
    public function getScenes(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if ($festivalId === null || !is_numeric($festivalId)) {
            echo "error, id = " . $festivalId ?? "null";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);

        if (!$festival) {
            echo "error, festival is null";
            return;
        }
        
        $scenes = $festival->getScenes();
        
        echo json_encode($scenes);
    }

}