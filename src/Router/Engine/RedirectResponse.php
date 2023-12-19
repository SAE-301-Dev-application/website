<?php

namespace MvcLite\Router\Engine;

/**
 * Redirection management class.
 *
 * @author belicfr
 */
class RedirectResponse
{
    /** Redirection route. */
    private Route $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    public function redirect(): void
    {
        header("Location: " . $this->route->getPath());
    }
}