<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\CreateFestivalAddScenesController;
use MvcLite\Controllers\CreateSceneController;
use MvcLite\Controllers\IndexController;
use MvcLite\Controllers\ProfileController;
use MvcLite\Controllers\RegisterController;
use MvcLite\Controllers\DashboardController;
use MvcLite\Controllers\FestivalsController;
use MvcLite\Controllers\CreateFestivalController;
use MvcLite\Controllers\CreateSpectacleController;
use MvcLite\Controllers\GrijFestivalController;
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

Router::post("/festivals", FestivalsController::class, "render")
    ->setName("post.festivals");


Router::get("/create-festival", CreateFestivalController::class, "render")
    ->setName("createFestival");

Router::post("/create-festival", CreateFestivalController::class, "createFestival")
    ->setName("post.createFestival");

    
Router::get("/create-spectacle", CreateSpectacleController::class, "render")
    ->setName("createSpectacle");

Router::post("/create-spectacle", CreateSpectacleController::class, "createSpectacle")
    ->setName("post.createSpectacle");


Router::get("/create-scene", CreateSceneController::class, "render")
    ->setName("createScene");

Router::post("/create-scene", CreateSceneController::class, "createScene")
    ->setName("post.createScene");


Router::get("/grij-festival", GrijFestivalController::class, "render")
    ->setName("grijFestival");


Router::get("/profile", ProfileController::class, "render")
    ->setName("profile");

Router::post("/profile/general-information/save",
             ProfileController::class,
             "saveGeneralInformation")
    ->setName("post.profile.generalInformation.save");

Router::post("/profile/new-password/save",
    ProfileController::class,
    "saveNewPassword")
    ->setName("post.profile.newPassword.save");


Router::get("/add-scene", CreateFestivalAddScenesController::class, "render")
    ->setName("addScene");
