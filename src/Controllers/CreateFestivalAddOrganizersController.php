<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Festival;
use MvcLite\Models\Scene;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateFestivalAddOrganizersController extends Controller
{
    private const REGEX_ID_PARAMETER = "/^([1-9])([0-9]*)$/";

    private const ERROR_IRRETRIEVABLE_USER
        = "Cet utilisateur n'existe pas ou plus.";

    private const ERROR_IMPOSSIBLE_TO_MANAGE_THIS_FESTIVAL
        = "Vous ne pouvez pas gérer ce festival.";

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
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_FESTIVAL;
        }
        
        $festival = Festival::getFestivalById($festivalId);

        View::render("CreateFestivalAddOrganizers", [
            "festival" => $festival,
        ]);

        return true;
    }

    public function getOrganizers(Request $request): void
    {
        $festivalId = $request->getParameter("festival");

        if ($festivalId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_FESTIVAL;
            return;
        }

        $festival = Festival::getFestivalById($festivalId);

        echo json_encode($festival->getOrganizers());
    }

    public function searchOrganizer(Request $request): void
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

        echo json_encode(User::searchByName($searchValue));
    }

    public function addOrganizer(Request $request): void
    {
        $festivalId = $request->getInput("festivalId");
        $organizerId = $request->getInput("userId");

        if ($festivalId === null
            || $organizerId === null
            || !self::isRetrievableFestival($festivalId)
            || !self::isManageableFestival($festivalId))
        {
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_FESTIVAL;
            return;
        }

        if (!self::isRetrievableUser($organizerId))
        {
            echo self::ERROR_IRRETRIEVABLE_USER;
            return;
        }

        $user = User::getUserById($organizerId);
        $festival = Festival::getFestivalById($festivalId);

        if (!$festival->hasOrganizer($user))
        {
            $festival->addOrganizer($user);
            echo "success";
        }
    }

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

        if (!self::isRetrievableUser($sceneId))
        {
            echo self::ERROR_IRRETRIEVABLE_USER;
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
        return Festival::getFestivalById($festivalId)->getOwner()->getId() == Session::getSessionId();
    }

    /**
     * @param string $userId
     * @return bool If given scene id is valid (non-negative and non-null integer)
     */
    private static function isRetrievableUser(string $userId): bool
    {
        return preg_match(self::REGEX_ID_PARAMETER, $userId)
               && Scene::getSceneById($userId) !== null;
    }
}