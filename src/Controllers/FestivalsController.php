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
    public function render(Request $request): RedirectResponse|true
    {
        $pageNumber = $request->getParameter("page") ?? 1;

        if (!is_numeric($pageNumber) || !self::getPageFestivals($pageNumber))
        {
            return Redirect::route("festivals")
                ->redirect();
        }

        View::render("Festivals", [
            "festivals"     => self::getPageFestivals($pageNumber),
            "pagesCount"    => self::getPagesCount(),
        ]);

        return true;
    }

    private static function getFestivalsPagination(): Pagination
    {
        $festivals = Festival::queryToArray(Festival::getAllFestivals());

        return new Pagination($festivals, 6);
    }

    private static function getPageFestivals(int $pageNumber): ?array
    {
        return self::getFestivalsPagination()
            ->getPage($pageNumber);
    }

    private static function getPagesCount(): int
    {
        return self::getFestivalsPagination()
            ->count();
    }
}