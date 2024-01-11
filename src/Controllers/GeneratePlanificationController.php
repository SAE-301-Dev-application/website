<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Models\Festival;
use MvcLite\Middlewares\AuthMiddleware;
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

    public function getFestivalGrij(int $idFestival): void
    {
        $festival = Festival::getFestivalById($idFestival);
        $festival->getGrij();
    }

}