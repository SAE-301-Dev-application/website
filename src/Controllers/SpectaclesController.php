<?php

namespace MvcLite\Controllers;

use MvcLite\Database\Engine\Pagination;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
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
    public function render(Request $request): RedirectResponse|true
    {
        $pageNumber = $request->getParameter("page") ?? 1;

        if (!is_numeric($pageNumber) || !self::getPageSpectacles($pageNumber))
        {
            return Redirect::route("spectacles")
                ->redirect();
        }

        View::render("Spectacles", [
            "spectacles"    => self::getPageSpectacles($pageNumber),
            "pagesCount"    => self::getPagesCount(),
        ]);

        return true;
    }

    private static function getSpectaclesPagination(): Pagination
    {
        $spectacles = Spectacle::queryToArray(Spectacle::getAllSpectacles());

        return new Pagination($spectacles, 6);
    }

    private static function getPageSpectacles(int $pageNumber): ?array
    {
        return self::getSpectaclesPagination()
            ->getPage($pageNumber);
    }

    private static function getPagesCount(): int
    {
        return self::getSpectaclesPagination()
            ->count();
    }
}