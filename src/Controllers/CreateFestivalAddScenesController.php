<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Festival;
use MvcLite\Models\Scene;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateFestivalAddScenesController extends Controller
{
    private const REGEX_ID_PARAMETER = "/^([1-9])([0-9]*)$/";

    private const ERROR_IRRETRIEVABLE_SCENE
        = "Cette scène n'existe pas ou plus.";

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function render(Request $request): RedirectResponse|true
    {
        $festivalId = $request->getParameter("festival");

        if ($festivalId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
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

    public function getScenes(Request $request): RedirectResponse|true
    {
        $festivalId = $request->getParameter("festival");

        if ($festivalId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            return Redirect::route("festivals")
                ->redirect();
        }

        $festival = Festival::getFestivalById($festivalId);

        echo json_encode($festival->getScenes());
        return true;
    }

    public function searchScene(Request $request): void
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

        echo json_encode(Scene::searchSceneByName($searchValue));
    }

    public function addScene(Request $request): void
    {
        $festivalId = $request->getParameter("festival");
        $sceneId = $request->getInput("sceneId");

        if ($festivalId === null
            || $sceneId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            Redirect::route("festivals")
                ->redirect();

            return;
        }

        if (!self::isRetrievableScene($sceneId))
        {
            echo self::ERROR_IRRETRIEVABLE_SCENE;
            return;
        }

        $scene = Scene::getSceneById($sceneId);
        $festival = Festival::getFestivalById($festivalId);

        if (!$festival->hasScene($scene))
        {
            $festival->addScene($scene);
            echo "success";
        }
    }

    /**
     * Remove a festival's scene given their id
     *
     * @param Request $request
     */
    public function removeScene(Request $request): void
    {
        $festivalId = $request->getParameter("festival");
        $sceneId = $request->getInput("sceneId");

        if ($festivalId === null
            || $sceneId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            Redirect::route("festivals")
                ->redirect();

            return;
        }

        if (!self::isRetrievableScene($sceneId))
        {
            echo self::ERROR_IRRETRIEVABLE_SCENE;
            return;
        }

        $scene = Scene::getSceneById($sceneId);
        $festival = Festival::getFestivalById($festivalId);

        if ($festival->hasScene($scene))
        {
            $festival->removeScene($scene);
            echo "success";
        }
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
     * @param string $sceneId
     * @return bool If given scene id is valid (non-negative and non-null integer)
     */
    private static function isRetrievableScene(string $sceneId): bool
    {
        return preg_match(self::REGEX_ID_PARAMETER, $sceneId)
               && Scene::getSceneById($sceneId) !== null;
    }
}