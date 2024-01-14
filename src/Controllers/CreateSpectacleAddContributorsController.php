<?php

namespace MvcLite\Controllers;

use MvcLite\Controllers\Engine\Controller;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Session\Session;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Models\Festival;
use MvcLite\Models\Spectacle;
use MvcLite\Models\Scene;
use MvcLite\Models\User;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Router\Engine\RedirectResponse;
use MvcLite\Router\Engine\Request;
use MvcLite\Views\Engine\View;

class CreateSpectacleAddContributorsController extends Controller
{

    private const REGEX_ID_PARAMETER = "/^([1-9])([0-9]*)$/";

    private const ERROR_IMPOSSIBLE_TO_MANAGE_THIS_SPECTACLE
        = "Vous ne pouvez pas gérer ce spectacle.";

    public function __construct()
    {
        parent::__construct();

        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    public function render(Request $request): RedirectResponse|true
    {
        {
            $spectacleId = $request->getParameter("id");
    
            if ($spectacleId === null
                || !self::isRetrievableSpectacle($spectacleId)
                || !self::isManageableSpectacle($spectacleId))
            {
                echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_SPECTACLE;
            }
            
            $spectacle = Spectacle::getSpectacleById($spectacleId);
    
            View::render("CreateSpectacleAddContributors", [
                "spectacle" => $spectacle,
            ]);
    
            return true;
        }
    }

    public function getContributors(Request $request): void
    {
        $spectacleId = $request->getParameter("id");

        if ($spectacleId === null
            || !self::isRetrievableSpectacle($spectacleId)
            || !self::isManageableSpectacle($spectacleId))
        {
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_SPECTACLE;
            return;
        }

        $spectacle = Spectacle::getSpectacleById($spectacleId);

        echo json_encode($spectacle->getContributors());
    }

    public function searchContributor(Request $request): void
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

    public function addContributor(Request $request): void
    {
        $spectacleId = $request->getInput("spectacleId");
        
        $contributorId = $request->getInput("userId");

        if ($spectacleId === null
            || $contributorId === null
            || !self::isRetrievableSpectacle($spectacleId)
            || !self::isManageableSpectacle($spectacleId))
        {
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_SPECTACLE;
            return;
        }

        if (!self::isRetrievableUser($contributorId))
        {
            echo self::ERROR_IRRETRIEVABLE_USER;
            return;
        }

        $user = User::getUserById($contributorId);
        $spectacle = Spectacle::getSpectacleById($spectacleId);

        if (!$spectacle->hasContributor($user))
        {
            $spectacle->addContributor($user);
            echo "success";
            return;
        }

        echo sprintf(self::ERROR_USER_ALREADY_CONTRIBUTOR, $user->getFirstname(), $user->getLastname());
    }

    public function removeContributor(Request $request): void
    {
        $spectacleId = $request->getInput("spectacleId");
        $contributorId = $request->getInput("userId");

        if ($spectacleId === null
            || $contributorId === null
            || !self::isRetrievableSpectacle($spectacleId)
            || !self::isManageableSpectacle($spectacleId))
        {
            echo self::ERROR_IMPOSSIBLE_TO_MANAGE_THIS_SPECTACLE;
            return;
        }

        if (!self::isRetrievableUser($contributorId))
        {
            echo self::ERROR_IRRETRIEVABLE_USER;
            return;
        }

        if ($contributorId == Session::getSessionId())
        {
            echo self::ERROR_OWNER_REMOVES_HIMSELF;
            return;
        }

        $user = User::getUserById($contributorId);
        $spectacle = Spectacle::getSpectacleById($spectacleId);

        if ($spectacle->hasContributor($user))
        {
            $spectacle->removeContributor($user);
            echo "success";
            return;
        }

        echo sprintf(self::ERROR_NON_CONTRIBUTOR_USER, $user->getFirstname(), $user->getLastname());
    }

    /**
     * @param int $spectacleId
     * @return bool If given spectacle id is valid (non-negative and non-null integer)
     */
    private static function isRetrievableSpectacle(int $spectacleId): bool
    {
        return preg_match(self::REGEX_ID_PARAMETER, $spectacleId)
               && Spectacle::getSpectacleById($spectacleId) !== null;
    }

    /**
     * @param string $spectacleId
     * @return bool If given spectacle id corresponds to a spectacle that current user can manage
     */
    private static function isManageableSpectacle(string $spectacleId): bool
    {
        return Spectacle::getSpectacleById($spectacleId)->getOwner()->getId() == Session::getSessionId();
    }
    
}