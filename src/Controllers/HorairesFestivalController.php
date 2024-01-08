<?php

namespace MvcLite\Controllers;

use MvcLite\Engine\Security\Validator;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MVCLite\Router\Engine\Request;
use MVCLite\Router\Engine\RedirectResponse;
use MvcLite\Controllers\Engine\Controller;
use MvcLite\Middlewares\AuthMiddleware;
use MvcLite\Router\Engine\Redirect;
use MvcLite\Views\Engine\View;
use MvcLite\Models\Festival;

class HorairesFestivalController extends Controller
{
    private const ERROR_REQUIRED_FIELD
        = "Ce champ est requis.";

    private const ERROR_MAX_LENGTH_NAME
        = "Le nom du festival ne doit pas dépasser 50 caractères.";

    private const ERROR_MAX_LENGTH_DESCRIPTION
        = "La description du festival ne doit pas dépasser 1000 caractères.";

    private const ERROR_NAME_ALREADY_USED
        = "Ce nom de festival est déjà utilisé.";
        
    private const ERROR_ENDING_BEFORE_BEGINNING_DATE
        = "La date de fin ne peut pas être antérieure à celle de début.";

    private const ERROR_START_DATE_IN_PAST
        = "La date de début est passée. Choisissez-en une dans le futur.";

    private const ERROR_END_DATE_IN_PAST
        = "La date de fin est passée. Choisissez-en une dans le futur.";

    private const ERROR_NO_CATEGORY_CHECKED
        = "Aucune catégorie n'a été renseignée pour ce festival. "
        . "Veuillez en choisir une.";

    private const ERROR_TYPE_NOT_SUPPORTED
        = "Le type d'illustration %s n'est pas supporté.";

    private const ERROR_DISRESPECTED_ILLUSTRATION_MAX_SIZE
        = "L'illustration ne peut pas avoir une dimension plus grande que "
        . self::ILLUSTRATION_MAX_WIDTH
        . 'x'
        . self::ILLUSTRATION_MAX_HEIGHT
        . ".";

    private const ILLUSTRATION_MAX_WIDTH = 800;

    private const ILLUSTRATION_MAX_HEIGHT = 600;

    /** Accepted illustration file types. */
    private const ILLUSTRATION_TYPES = [
        "png", "gif", "jpeg",
    ];

    public function __construct()
    {
        parent::__construct();

        $this->middleware(AuthMiddleware::class);
    }

    /**
     * Festival creation view rendering.
     */
    public function render(): void
    {
        View::render("PlanifierSpectacle");
    }
}