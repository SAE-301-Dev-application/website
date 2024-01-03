<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class FestivalsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function render(): void
    {
        View::render("Festivals");
    }
}