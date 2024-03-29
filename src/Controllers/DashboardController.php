<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }   

    public function render(): void
    {
        $lastFestivals = Festival::lastFestivals();
        
        View::render("Dashboard", [
            "lastFestivals" => $lastFestivals,
        ]);
    }
}