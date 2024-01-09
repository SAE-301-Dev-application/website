<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Spectacle extends Model
{
    /** Default festival illustration path. */
    private const DEFAULT_FESTIVAL_ILLUSTRATION_PATH
        = "default_illustration.png";

    /** Spectacle's id. */
    private int $id;

    /** Spectacle's name. */
    private string $title;

    /** Spectacle's description. */
    private string $description;

    /** Spectacle's duration. */
    private string $duration;

    /** Spectacle's scene size. */
    private string $sceneSize;

    /** Spectacle's illustration */
    private string $illustration;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("spectacle");
    }

    /**
     * @return int Spectacle's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id Spectacle's id
     * @return int Spectacle's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string Spectacle's name
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title New spectacle's title
     * @return string New spectacle's title
     */
    public function setTitle(string $title): string
    {
        return $this->title = $title;
    }

    /**
     * @return string Spectacle's description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description New spectacle's description
     * @return string New spectacle's description
     */
    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    /**
     * @return string Spectacle's duration
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration New spectacle's duration
     * @return string New spectacle's duration
     */
    public function setDuration(string $duration): string
    {
        return $this->duration = $duration;
    }

    /**
     * @return string Spectacle's scene size
     */
    public function getSceneSize(): string
    {
        return $this->sceneSize;
    }

    /**
     * @param string $sceneSize New spectacle's scene size
     * @return string New spectacle's scene size
     */
    public function setSceneSize(string $sceneSize): string
    {
        return $this->sceneSize = $sceneSize;
    }

    /**
     * @return array Spectacle's categories
     */
    public function getCategories(): array
    {
        return [];  // TODO stumb
    }

    /**
     * @return string Spectacle's illustration
     */
    public function getIllustration(): string
    {
        return $this->illustration;
    }

    /**
     * @param string $illustration New spectacle's illustration
     * @return string New spectacle's illustration
     */
    public function setIllustration(string $illustration): string
    {
        return $this->illustration = $illustration;
    }

    public function getOwner(): ?User
    {
        return new User();  // TODO STUB
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

    /**
     * Get all spectacles.
     * 
     * @return array Spectacles
     */
    public static function getSpectacles(): array
    {
        $getSpectaclesQuery
            = "SELECT *
               FROM spectacle
               ORDER BY id_spectacle ASC;";

        $result = Database::query($getSpectaclesQuery);

        return $result->getAll();
    }

    /**
     * Get path to a spectacle's illustration.
     * 
     * @param ?string $name
     * @return string Spectacle's illustration path
     */
    public static function getImagePathByName(?string $name)
    {
        // TODO: delete? !!
        $illustrationPath = ROUTE_PATH_PREFIX
            . "src/Resources/Medias/Images/";

        $defaultIllustration = "default_illustration.png";

        return !$name || $name === $defaultIllustration
            ? $illustrationPath . $defaultIllustration
            : $illustrationPath . "SpectaclesUploads/" . $name;
    }

    /**
     * Searches and returns Spectacle instance by its id.
     *
     * @param int $id Spectacle id
     * @return Festival|null Spectacle object if exists;
     *                       else NULL
     */
    public static function getSpectacleById(int $id): ?Spectacle
    {
        $query = "SELECT * FROM spectacle WHERE id_spectacle = ?";

        $getSpectacle = Database::query($query, $id);
        $spectacle = $getSpectacle->get();

        if ($spectacle)
        {
            $spectacleInstance = new Spectacle();

            $spectacleInstance
                ->setId($id);

            $spectacleInstance
                ->setTitle($spectacle["titre_sp"]);

            $spectacleInstance
                ->setDescription($spectacle["description_sp"]);

            $spectacleInstance
                ->setIllustration($spectacle["illustration_sp"] ?? self::DEFAULT_FESTIVAL_ILLUSTRATION_PATH);

            $spectacleInstance
                ->setDuration($spectacle["duree_sp"]);

            $spectacleInstance
                ->setSceneSize($spectacle["taille_scene_sp"]);

            return $spectacleInstance;
        }

        return null;
    }

    /**
     * Attempts to delete a spectacle by its id.
     *
     * @return bool If spectacle is successfully deleted
     */
    public function delete(): bool
    {
        $query = "DELETE FROM spectacle WHERE id_spectacle = ?";

        $spectacleDeleting = Database::query($query, $this->getId());

        return $spectacleDeleting->getExecutionState();
    }

    /**
     * Returns User array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array users array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];

        while ($line = $queryObject->get())
        {
            $modelArray[] = self::getSpectacleById($line["id_spectacle"]);
        }

        return $modelArray;
    }
}