<?php

namespace MvcLite\Router\Engine;

use MvcLite\Engine\DevelopmentUtilities\Debug;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class Redirect
{
    /**
     * Redirection by route path.
     *
     * @param string $path Route path
     * @return RedirectResponse Redirect object
     */
    public static function to(string $path): RedirectResponse
    {
        $pathSplit = explode('?', $path);
        $path = $pathSplit[0];
        $parameters = $pathSplit[1] ?? "";

        $_POST = $_GET = [];

        $route = Router::getRouteByPath($path);

        return new RedirectResponse($route, $parameters);
    }

    /**
     * Redirection by route name.
     *
     * @param string $name Route name
     * @return RedirectResponse Redirect object
     */
    public static function route(string $name): RedirectResponse
    {
        $route = Router::getRouteByName($name);

        return new RedirectResponse($route);
    }
}