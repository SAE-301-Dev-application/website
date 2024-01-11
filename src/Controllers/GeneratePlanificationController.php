<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Models\Festival;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Request;
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
     */
    public function render(): void
    {
        View::render("GeneratePlanification");
    }

    /**
     * Get festival's GriJ and send it (ajax request).
     * 
     * @param Request $request
     */
    public function getFestivalGrij(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if (!is_numeric($festivalId)) {
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
    public function getFestivalSpectacles(Request $request): void
    {
        $festivalId = $request->getParameter("id");

        if (!is_numeric($festivalId)) {
            echo "error, id = " . $festivalId ?? "null";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);

        if (!$festival) {
            echo "error, festival is null";
            return;
        }
        
        $spectacles = Festival::getSpectaclesByFestivalId($festival->getId());

        echo json_encode($spectacles);
    }

    /**
     * Get festival's scenes and send it (ajax request).
     * 
     * @param Request $request
     */
    public function getFestivalScenes(Request $request): void
    {
        $festivalId = $request->getInput("id");

        if (!is_numeric($festivalId)) {
            echo "error";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);
        
        $scenes = Festival::getScenes($festival->getId());

        echo json_encode($scenes);
    }

}