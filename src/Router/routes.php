<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\IndexController;
use MvcLite\Controllers\RegisterController;
use MvcLite\Controllers\DashboardController;
use MvcLite\Controllers\CreateFestivalController;
use MvcLite\Controllers\SessionController;
use MvcLite\Router\Engine\Router;

Router::get("/", IndexController::class, "redirectionIndex");


Router::get("/index", IndexController::class, "render")
    ->setName("index");

Router::post("/index/login", IndexController::class, "login")
    ->setName("post.login");


Router::get("/register", RegisterController::class, "render")
    ->setName("register");

Router::post("/register", RegisterController::class, "register")
    ->setName("post.register");


Router::get("/logout", SessionController::class, "logout")
    ->setName("logout");


Router::get("/dashboard", DashboardController::class, "render")
    ->setName("dashboard");

Router::get("/create-festival", CreateFestivalController::class, "render")
    ->setName("create-festival");