<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function redirectionIndex()
    {
        Redirect::route("index");
    }

    public function render(): void
    {
        View::render("Index");
    }

    public function login(Request $request)
    {
        Debug::dd($request->getInputs());
    }
}