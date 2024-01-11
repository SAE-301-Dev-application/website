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
        $festivalId = $request->getInput("id");

        if (!is_numeric($festivalId)) {
            echo "error";
            return;
        }

        $festivalId = intval($festivalId);

        $festival = Festival::getFestivalById($festivalId);
        
        $grij = Festival::getGrij($festival->getId());

        echo json_encode($grij);
    }

    /**
     * Get festival's scenes and send it (ajax request).
     */
    public function getFestivalScenes(int $idFestival): void
    {
        $festival = Festival::getFestivalById($idFestival);

        $scenes = Festival::getScenes($festival->getId());

        echo serialize($scenes);
    }

    /**
     * Get festival's spectacles and send it (ajax request).
     */
    public function getFestivalSpectacles(int $idFestival): void
    {
        $festival = Festival::getFestivalById($idFestival);

        $spectacles = Festival::getSpectacles($festival->getId());

        echo serialize($spectacles);
    }

}