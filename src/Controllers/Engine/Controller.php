<?php

namespace MvcLite\Controllers\Engine;

use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Middlewares\ExistingAccountMiddleware;

/**
 * General controller class. Used by all MVCLite
 * controllers.
 *
 * It implements controller utilities methods like
 * middleware one. Also, it adds global controller
 * scripts like ExistingAccount middleware call.
 *
 * @author belicfr
 */
class Controller
{
    public function __construct()
    {
        $this->middleware(ExistingAccountMiddleware::class);
    }

    /**
     * @param string $middleware Middleware class
     */
    protected function middleware(string $middleware): void
    {
        $middlewareInstance = new $middleware();
        $middlewareInstance->run();
    }
}