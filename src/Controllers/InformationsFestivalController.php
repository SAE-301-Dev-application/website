<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;
use MvcLite\Models\Spectacle;
use MvcLite\Models\GriJ;

class InformationsFestivalController extends Controller
{
    private const REGEX_ID_PARAMETER = "/^([1-9])([0-9]*)$/";


    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festivals display view rendering.
     *
     * @param Request $request
     * @return RedirectResponse|true
     */
    public function render(Request $request): RedirectResponse|true
    {

        $id = $request->getParameter("id");


        if (!Festival::getFestivalById($id))
        {
            return Redirect::route("festivals")
                ->redirect();
        }
        $festival = Festival::getFestivalById($id);
        $isOrganizer = self::isManageableFestival($id);

        View::render("InformationsFestival", [
            "festival" => $festival,
            "isOrganizer" => $isOrganizer,
        ]);

        return true;
    }

    /**
     * @param string $festivalId
     * @return bool If given festival id corresponds to a festival that current user can manage
     */
    private static function isManageableFestival(string $festivalId): bool
    {
        return Festival::getFestivalById($festivalId)->getOwner()->getId() == Session::getSessionId()
            || Festival::getFestivalById($festivalId)->hasOrganizer(Session::getUserAccount());
    }
}