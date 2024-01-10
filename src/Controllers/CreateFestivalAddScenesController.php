<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Models\Festival;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateFestivalAddScenesController extends Controller
{
    private const REGEX_FESTIVAL_PARAMETER = "/^([1-9]+)$/";

    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function render(Request $request): RedirectResponse|true
    {
        $festivalId = $request->getParameter("festival");

        if (!preg_match(self::REGEX_FESTIVAL_PARAMETER, $festivalId)
            || Festival::getFestivalById($festivalId) === null)
        {
            return Redirect::route("festivals")
                ->redirect();
        }
        
        $festival = Festival::getFestivalById($festivalId);

        View::render("CreateFestivalAddScenes", [
            "festival" => $festival,
        ]);

        return true;
    }
}