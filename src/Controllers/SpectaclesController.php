<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Spectacle;

class SpectaclesController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Spectacles display view rendering.
     * 
     * @param Request $request
     */
    public function render(Request $request): void
    {
        $spectacles = Spectacle::getSpectacles();

        $startIndex = $request->getParameter("indice")
            ? intval($request->getParameter("indice")) ?? 0
            : 0;

        $spectaclesCount = count($spectacles);

        if ($startIndex < 0 || $startIndex >= $spectaclesCount
            || !is_int($startIndex) || $startIndex % 6 !== 0) {
            Redirect::route("spectacles");
            die;
        }

        $indexLastPage = $spectaclesCount % 6 === 0
            ? $spectaclesCount - 6
            : $spectaclesCount - ($spectaclesCount % 6);
        
        $previousVisibility = $startIndex === 0 ? " link-disabled" : "";
        $nextVisibility = $startIndex + 6 >= $spectaclesCount ? " link-disabled" : "";

        View::render("Spectacles", [
            "spectacles" => $spectacles,
            "startIndex" => $startIndex,
            "indexLastPage" => $indexLastPage,
            "previousVisibility" => $previousVisibility,
            "nextVisibility" => $nextVisibility,
        ]);
    }
}