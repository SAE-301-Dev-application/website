<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\CreateFestivalAddSpectaclesController;
use MvcLite\Controllers\IndexController;
use MvcLite\Controllers\CreateFestivalController;
use MvcLite\Controllers\ProfileController;
use MvcLite\Controllers\CreateFestivalAddScenesController;
use MvcLite\Controllers\CreateFestivalAddGrijController;
use MvcLite\Controllers\CreateSpectacleController;
use MvcLite\Controllers\CreateSceneController;
use MvcLite\Controllers\DashboardController;
use MvcLite\Controllers\FestivalsController;
use MvcLite\Controllers\GeneratePlanificationController;
use MvcLite\Controllers\InformationsFestivalController;
use MvcLite\Controllers\InformationsSpectacleController;
use MvcLite\Controllers\ModifyFestivalController;
use MvcLite\Controllers\RegisterController;
use MvcLite\Controllers\SessionController;
use MvcLite\Controllers\SpectaclesController;
use MvcLite\Controllers\CreateSpectacleAddIntervenantsController;

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


Router::get("/spectacles", SpectaclesController::class, "render")
    ->setName("spectacles");


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


Router::get("/grij-festival", CreateFestivalAddGrijController::class, "render")
    ->setName("grijFestival");


Router::get("/profile", ProfileController::class, "render")
    ->setName("profile");

Router::get("/profile/get", ProfileController::class, "getSessionUserFestivals")
    ->setName("profile.getFestivals");

Router::post("/profile/delete", ProfileController::class, "deleteFestival")
    ->setName("post.profile.deleteFestival");

Router::post("/profile/general-information/save",
             ProfileController::class,
             "saveGeneralInformation")
    ->setName("post.profile.generalInformation.save");

Router::post("/profile/new-password/save",
             ProfileController::class,
             "saveNewPassword")
    ->setName("post.profile.newPassword.save");

Router::post("/profile/delete-account/confirm",
             ProfileController::class,
             "confirmDeleteAccount")
    ->setName("post.profile.deleteAccount.confirm");

    
Router::get("/informations-festival", InformationsFestivalController::class, "render")
    ->setName("informationsFestival");

    
Router::get("/informations-spectacle", InformationsSpectacleController::class, "render")
    ->setName("informationsSpectacle");


Router::get("/modify-festival", ModifyFestivalController::class, "render")
    ->setName("modifyFestival");


Router::get("/add-scene", CreateFestivalAddScenesController::class, "render")
    ->setName("addScene");

Router::get("/add-scene/get", CreateFestivalAddScenesController::class, "getScenes")
    ->setName("addScene.getScenes");

Router::get("/add-scene/search", CreateFestivalAddScenesController::class, "searchScene")
    ->setName("addScene.searchScene");

Router::post("/add-scene/add", CreateFestivalAddScenesController::class, "addScene")
    ->setName("addScene.addScene");

Router::post("/add-scene/remove", CreateFestivalAddScenesController::class, "removeScene")
    ->setName("addScene.removeScene");


Router::get("/generate-planification", GeneratePlanificationController::class, "render")
    ->setName("generatePlanification");

Router::get("/generate-planification/get-festival", GeneratePlanificationController::class, "getFestival")
    ->setName("generatePlanification.getFestival");

Router::get("/generate-planification/get-grij", GeneratePlanificationController::class, "getGrij")
    ->setName("generatePlanification.getGrij");

Router::get("/generate-planification/get-spectacles", GeneratePlanificationController::class, "getSpectacles")
    ->setName("generatePlanification.getSpectacles");

Router::get("/generate-planification/get-scenes", GeneratePlanificationController::class, "getScenes")
    ->setName("generatePlanification.getScenes");

    
Router::get("/add-spectacle", CreateFestivalAddSpectaclesController::class, "render")
    ->setName("addSpectacle");

Router::get("/add-spectacle/get-spectacles", CreateFestivalAddSpectaclesController::class, "getSpectacles")
    ->setName("addSpectacle.getSpectacles");

Router::get("/add-spectacle/search", CreateFestivalAddSpectaclesController::class, "searchSpectacle")
    ->setName("addSpectacle.searchSpectacle");

Router::post("/add-spectacle/add", CreateFestivalAddSpectaclesController::class, "addSpectacle")
    ->setName("post.addSpectacle.addSpectacle");

Router::post("/add-spectacle/remove", CreateFestivalAddSpectaclesController::class, "removeSpectacle")
    ->setName("post.addSpectacle.removeSpectacle");


Router::get("/add-intervenants", CreateSpectacleAddIntervenantsController::class, "render")
    ->setName("addIntervenants");

// Page pas encore créée, route pour redirection "Profil" → "Modifier spectacle"
Router::get("/modify-spectacle", ModifySpectacleController::class, "render")
    ->setName("modifySpectacle");