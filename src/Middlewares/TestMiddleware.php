<?php

namespace MvcLite\Middlewares;

use MvcLite\Middlewares\Engine\Middleware;
use MvcLite\Router\Engine\Redirect;

class TestMiddleware extends Middleware
{
    private int $i = 5;

    public function __construct()
    {
        parent::__construct();

        // Empty constructor.
    }

    public function run(): bool
    {
        if ($this->i != 1)
        {
            echo "TEST MIDDLEWARE ERROR";
            die;
        }

        return parent::run();
    }
}