<?php

/*
 * routes.php
 * MVCLite framework by belicfr
 */


use MvcLite\Controllers\CreateFestivalAddOrganizersController;
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
use MvcLite\Controllers\CreateSpectacleAddContributorsController;

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


Router::get("/add-grij-festival", CreateFestivalAddGrijController::class, "render")
    ->setName("addGrijFestival");


Router::get("/profile", ProfileController::class, "render")
    ->setName("profile");

Router::get("/profile/getFestivals", ProfileController::class, "getSessionUserFestivals")
    ->setName("profile.getFestivals");

Router::get("/profile/getSpectacles", ProfileController::class, "getSessionUserSpectacles")
    ->setName("profile.getSpectacles");


Router::post("/profile/deleteFestival", ProfileController::class, "deleteFestival")
    ->setName("post.profile.deleteFestival");

Router::post("/profile/deleteSpectacle", ProfileController::class, "deleteSpectacle")
    ->setName("post.profile.deleteSpectacle");

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

Router::post("/modify-festival", ModifyFestivalController::class, "modifyFestival")
    ->setName("post.modifyFestival");

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


Router::get("/add-organizer", CreateFestivalAddOrganizersController::class, "render")
    ->setName("addOrganizer");

Router::get("/add-organizer/get", CreateFestivalAddOrganizersController::class, "getOrganizers")
    ->setName("addOrganizer.getOrganizers");

Router::get("/add-organizer/search", CreateFestivalAddOrganizersController::class, "searchOrganizer")
    ->setName("addOrganizer.searchOrganizer");

Router::post("/add-organizer/add", CreateFestivalAddOrganizersController::class, "addOrganizer")
    ->setName("addOrganizer.addOrganizer");

Router::post("/add-organizer/give", CreateFestivalAddOrganizersController::class, "giveFestivalToOrganizer")
    ->setName("addOrganizer.giveFestival");

Router::post("/add-organizer/remove", CreateFestivalAddOrganizersController::class, "removeOrganizer")
    ->setName("addOrganizer.removeOrganizer");


Router::get("/add-contributor", CreateSpectacleAddContributorsController::class, "render")
    ->setName("addContributors");

Router::get("/add-contributor/get", CreateFestivalAddContributorsController::class, "getContributors")
    ->setName("addContributor.getContributors");

Router::get("/add-contributor/search", CreateFestivalAddContributorsController::class, "searchContributor")
    ->setName("addContributor.searchContributor");

Router::post("/add-contributor/add", CreateFestivalAddContributorsController::class, "addContributor")
    ->setName("addContributor.addContributor");

Router::post("/add-contributor/give", CreateFestivalAddContributorsController::class, "giveContributor")
    ->setName("addContributor.giveContributor");

Router::post("/add-contributor/remove", CreateFestivalAddContributorsController::class, "removeContributor")
    ->setName("addContributor.removeContributor");


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


// Page pas encore créée, route pour redirection "Profil" → "Modifier spectacle"
Router::get("/modify-spectacle", ModifySpectacleController::class, "render")
    ->setName("modifySpectacle");