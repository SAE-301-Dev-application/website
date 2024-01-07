<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Spectacle extends Model
{
    /** Spectacle's name */
    private string $title;

    /** Spectacle's description. */
    private string $description;

    /** Spectacle's duration. */
    private string $duration;

    /** Spectacle's scene size. */
    private string $sceneSize;

    /** Spectacle's categories */
    private array $categories;

    /** Spectacle's illustration */
    private string $illustration;

    public function __construct(string $title,
                                string $description,
                                string $duration,
                                string $sceneSize,
                                array $categories,
                                string $illustration)
    {
        parent::__construct("spectacle");

        $this->name = $title;
        $this->description = $description;
        $this->beginningDate = $duration;
        $this->endingDate = $sceneSize;
        $this->categories = $categories;
        $this->illustration = $illustration;
    }

    /**
     * @return string Spectacle's name
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string Spectacle's description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string Spectacle's duration
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @return string Spectacle's scene size
     */
    public function getSceneSize(): string
    {
        return $this->sceneSize;
    }

    /**
     * @return array Spectacle's categories
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string Spectacle's illustration
     */
    public function getIllustration(): string
    {
        return $this->illustration;
    }

    /**
     * Attempt to create a spectacle and link categories to it.
     *
     * @param string $title
     * @param string $description
     * @param string $illustration
     * @param string $duration
     * @param string $sceneSize
     * @param array $categories
     */
    public static function create(string $title,
                                  string $description,
                                  ?string $illustration,
                                  string $duration,
                                  string $sceneSize,
                                  array $categories): void
    {
        $addSpectacleQuery = "SELECT ajouterSpectacle(?, ?, ?, ?, ?) AS id;";

        $linkCategorieQuery = "CALL ajouterSpectacleCategorie(?, ?);";

        switch ($sceneSize)
        {
            default:
            case "small":
                $sceneSize = 1;
                break;
            case "medium":
                $sceneSize = 2;
                break;
            case "large":
                $sceneSize = 3;
                break;
        }

        $spectacleId = Database::query($addSpectacleQuery,
                                       $title,
                                       $description,
                                       $illustration ?? null,
                                       $duration,
                                       $sceneSize);

        $spectacleId = $spectacleId->get()["id"];

        foreach ($categories as $categorie)
        {
            Database::query($linkCategorieQuery,
                            $spectacleId,
                            $categorie);
        }
    }

    /**
     * Check if a spectacle exists.
     * 
     * @param string $title
     * @return bool True if the spectacle exists, false otherwise.
     */
    public static function isTitleAlreadyTaken(string $title): bool
    {
        $checkTitleQuery = "SELECT verifierSpectacleExiste(?) AS resultat;";

        $result = Database::query($checkTitleQuery, $title);

        return $result->get()["resultat"] === 1;
    }
}