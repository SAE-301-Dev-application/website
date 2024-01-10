<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Views\Engine\View;

class GeneratePlanificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }


    public function render(): void
    {
        View::render("GeneratePlanification");
    }

}