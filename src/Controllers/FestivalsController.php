<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;

class FestivalsController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festivals display view rendering.
     * 
     * @param Request $request
     */
    public function render(Request $request): void
    {
        $festivals = Festival::getFestivals();

        $startIndex = $request->getParameter("indice")
            ? intval($request->getParameter("indice")) ?? 0
            : 0;

        $festivalsCount = count($festivals);

        if ($startIndex < 0 || $startIndex >= $festivalsCount
            || !is_int($startIndex) || $startIndex % 6 !== 0) {
            Redirect::route("festivals");
            die;
        }

        $indexLastPage = $festivalsCount % 6 === 0
            ? $festivalsCount - 6
            : $festivalsCount - ($festivalsCount % 6);
        
        $previousVisibility = $startIndex === 0 ? " link-disabled" : "";
        $nextVisibility = $startIndex + 6 >= $festivalsCount ? " link-disabled" : "";

        View::render("Festivals", [
            "festivals" => $festivals,
            "startIndex" => $startIndex,
            "indexLastPage" => $indexLastPage,
            "previousVisibility" => $previousVisibility,
            "nextVisibility" => $nextVisibility,
        ]);
    }
}