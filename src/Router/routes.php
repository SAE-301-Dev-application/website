<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\IndexController;
use MvcLite\Controllers\RegisterController;
use MvcLite\Controllers\DashboardController;
use MvcLite\Router\Engine\Router;

Router::get("/",IndexController::class, "redirectionIndex");

Router::get("/index", IndexController::class, "render")
    ->setName("index");


Router::get("/register", RegisterController::class, "render")
    ->setName("register");

Router::post("/register", RegisterController::class, "register")
    ->setName("post.register");

Router::get("/dashboard", DashboardController::class, "render")
    ->setName("dashboard");

Router::get("/dashboard", DashboardController::class, "render")
    ->setName("dashboard");