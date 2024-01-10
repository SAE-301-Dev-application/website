<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;

use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Views\Engine\View;

class PlanningGenerationController extends Controller
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
        View::render("PlanningGeneration");
    }

}