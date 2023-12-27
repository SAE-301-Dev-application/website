<?php

namespace MvcLite\Controllers\Engine;

use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Middlewares\ExistingAccountMiddleware;

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