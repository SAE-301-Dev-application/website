<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Festival;
use MvcLite\Models\Spectacle;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateFestivalAddSpectaclesController extends Controller
{

    private const REGEX_ID_PARAMETER = "/^([1-9])([0-9]*)$/";

    private const ERROR_IRRETRIEVABLE_SPECTACLE
        = "Cette scène n'existe pas ou plus.";


    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function render(Request $request): RedirectResponse|true
    {
        $festivalId = $request->getParameter("festival");
        
        if ($festivalId == null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            return Redirect::route("festivals")
                ->redirect();
        }

        $festival = Festival::getFestivalById($festivalId);

        View::render("CreateFestivalAddSpectacles", [
            "festival" => $festival,
        ]);

        return true;
    }

    public function getSpectacles(Request $request): RedirectResponse|true
    {
        $festivalId = $request->getParameter("festival");

        if ($festivalId == null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId)) {
            return Redirect::route("festivals")
                ->redirect();
        }

        $festival = Festival::getFestivalById($festivalId);

        echo json_encode($festival->getSpectacles());
        return true;
    }

    public function searchSpectacle(Request $request): void
    {
        $searchValue = $request->getParameter("search");

        if ($searchValue === null)
        {
            echo json_encode([
                "type" => "error",
                "message" => "Aucun terme de recherche n'est précisé.",
            ]);

            return;
        }
        echo json_encode(Spectacle::searchSpectacleByName($searchValue));
    }

    public function addSpectacle(Request $request): void
    {
        $festivalId = $request->getParameter("festival");
        $spectacleId = $request->getParameter("spectacle");

        if ($festivalId === null
            || $spectacleId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            Redirect::route("festivals")
                ->redirect();

            return;
        }

        if (!self::isRetrievableSpectacle($spectacleId))
        {
            echo self::ERROR_IRRETRIEVABLE_SPECTACLE;
            return;
        }

        $spectacle = Spectacle::getSpectacleById($spectacleId);
        $festival = Festival::getFestivalById($festivalId);

        if (!$festival->hasSpectacle($spectacle))
        {
            $festival->addSpectacle($spectacle);
            echo "success";
        }
    }

    public function removeSpectacle(Request $request): void
    {
        $festivalId = $request->getParameter("festival");
        $spectacleId = $request->getParameter("spectacle");

        if ($festivalId == null
            || $spectacleId == null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId)) {
            Redirect::route("festivals")
                ->redirect();

            return;
        }

        if (!self::isRetrievableSpectacle($spectacleId)) {
            echo self::ERROR_IRRETRIEVABLE_SPECTACLE;
            return;
        }

        $spectacle = Spectacle::getSpectacleById($spectacleId);

        $festival = Festival::getFestivalById($festivalId);
        $festival->removeSpectacle($spectacle);

        echo "success";
    }


    /**
     * @param string $festivalId
     * @return bool If given festival id is valid (non-negative and non-null integer)
     */
    private static function isRetrievableFestival(string $festivalId): bool
    {
        return preg_match(self::REGEX_ID_PARAMETER, $festivalId)
            && Festival::getFestivalById($festivalId) !== null;
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

    /**
     * @param string $spectacleId
     * @return bool If given spectacle id is valid (non-negative and non-null integer)
     */
    private static function isRetrievableSpectacle(string $spectacleId): bool
    {
        return preg_match(self::REGEX_ID_PARAMETER, $spectacleId)
            && Spectacle::getSpectacleById($spectacleId) !== null;
    }
}