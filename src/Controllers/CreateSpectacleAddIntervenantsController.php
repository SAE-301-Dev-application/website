<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;

class CreateSpectacleAddIntervenantsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function render(): void
    {
        View::render("CreateSpectacleAddIntervenants");
    }
}