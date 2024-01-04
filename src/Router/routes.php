<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\IndexController;
use MvcLite\Controllers\RegisterController;
use MvcLite\Controllers\DashboardController;
use MvcLite\Controllers\FestivalsController;
use MvcLite\Controllers\CreateFestivalController;
use MvcLite\Controllers\CreateSpectacleController;
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


Router::get("/festivals", FestivalsController::class, "render")
    ->setName("festivals");


Router::get("/create-festival", CreateFestivalController::class, "render")
    ->setName("createFestival");

Router::post("/create-festival", CreateFestivalController::class, "createFestival")
    ->setName("post.createFestival");

    
Router::get("/create-spectacle", CreateSpectacleController::class, "render")
    ->setName("createSpectacle");

Router::post("/create-spectacle", CreateSpectacleController::class, "createSpectacle")
    ->setName("post.createSpectacle");