<?php

namespace MvcLite\Engine\Session;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Router\Engine\Redirect;

/**
 * Session manager class.
 *
 * @author belicfr
 */
class Session
{
    /** $_SESSION key for current session id. */
    private const AUTH_SESSION_VARIABLE = "AUTH_SESSION_ID";

    /**
     * @return bool If visitor has a session id
     */
    public static function isLogged(): bool
    {
        return isset($_SESSION[self::AUTH_SESSION_VARIABLE]);
    }

    /**
     * @return int|false Current session id if logged;
     *                   else FALSE
     */
    public static function getSessionId(): int|false
    {
        return self::isLogged()
            ? $_SESSION[self::AUTH_SESSION_VARIABLE]
            : false;
    }

    /**
     * Attempt to log in the account corresponding to
     * given login and password.
     *
     * @param string $login
     * @param string $password
     * @return bool Log in attempt state
     */
    public static function attemptLogin(string $login, string $password): bool
    {
        $query = "SELECT * FROM "
                . AUTHENTIFICATION_COLUMNS["table"]
                . " WHERE "
                . AUTHENTIFICATION_COLUMNS["login"]
                . " = ?";

        $user = Database::query($query, $login)
            ->get();

        $attemptState
            = $user
              && Password::verify($password,
                                  $user[AUTHENTIFICATION_COLUMNS["password"]]);

        if ($attemptState)
        {
            self::setSessionId($user[AUTHENTIFICATION_COLUMNS["id"]]);
        }

        return $attemptState;
    }

    /**
     * Force to log in with given user id.
     *
     * @param int $sessionId Session id
     */
    private static function setSessionId(int $sessionId): void
    {
        $_SESSION[self::AUTH_SESSION_VARIABLE] = $sessionId;
    }

    /**
     * Log out from current session.
     */
    public static function logout(): void
    {
        session_destroy();
        Redirect::to("/");
    }

    /**
     * @return false|array Account array if exists;
     *                     else FALSE
     */
    public static function getSessionAccount(): false|array
    {
        if (!self::getSessionId())
        {
            return false;
        }

        $query = "SELECT * FROM "
               . AUTHENTIFICATION_COLUMNS["table"]
               . " WHERE "
               . AUTHENTIFICATION_COLUMNS["id"]
               . " = ?";

        $sessionAccount = Database::query($query, self::getSessionId());

        return $sessionAccount->get();
    }
}