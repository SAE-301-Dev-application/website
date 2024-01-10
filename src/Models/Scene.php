<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Scene extends Model
{
    /** User id. */
    private int $id;

    private string $name;

    private int $taille;

    private int $maxSpectateurs;

    private string $latitude;

    private string $longitude;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("scene");
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $title New spectacle's title
     * @return string New spectacle's title
     */
    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    /**
     * @return string Spectacle's description
     */
    public function getTaille(): int
    {
        return $this->taille;
    }

    /**
     * @param string $description New spectacle's description
     * @return int New spectacle's description
     */
    public function setTaille(int $taille): int
    {
        return $this->taille = $taille;
    }

    /**
     * @return string Spectacle's duration
     */
    public function getMaxSpectateurs(): int
    {
        return $this->maxSpectateurs;
    }

    /**
     * @param string $duration New spectacle's duration
     * @return string New spectacle's duration
     */
    public function setMaxSpectateurs(int $maxSpectateurs): int
    {
        return $this->maxSpectateurs = $maxSpectateurs;
    }

    /**
     * @return string Spectacle's scene size
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $sceneSize New spectacle's scene size
     * @return string New spectacle's scene size
     */
    public function setLatitude(string $latitude): string
    {
        return $this->latitude = $latitude;
    }

    /**
     * @return string Spectacle's scene size
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $sceneSize New spectacle's scene size
     * @return string New spectacle's scene size
     */
    public function setLongitude(string $longitude): string
    {
        return $this->longitude = $longitude;
    }

    /**
     * Attempt to create a scene with given information.
     *
     * @param string $nom
     * @param int $taille
     * @param int $maxSpectateurs
     * @param string $coordonnees
     * @return bool If the scene is being created
     */
    public static function create(string $nom,
                                  int $taille,
                                  int $maxSpectateurs,
                                  float $longitude,
                                  float $latitude): bool
    {
        $query = "CALL ajouterScene(?, ?, ?, ?, ?)";

        $user = Database::query($query,
                                $nom,
                                $taille,
                                $maxSpectateurs,
                                $latitude,
                                $longitude);

        return $user->getExecutionState();
    }

    /**
     * Searches and returns Spectacle instance by its id.
     *
     * @param int $id Spectacle id
     * @return Spectacle|null Spectacle object if exists;
     *                       else NULL
     */
    public static function getSceneById(int $id): ?Scene
    {
        $query = "SELECT * FROM scene WHERE id_scene = ?";

        $getScene = Database::query($query, $id);
        $scene = $getScene->get();

        if ($scene)
        {
            $sceneInstance = new Scene();

            $sceneInstance
                ->setId($id);

            $sceneInstance
                ->setName($scene["nom_sc"]);

            $sceneInstance
                ->setTaille($scene["taille_sc"]);

            $sceneInstance
                ->setMaxSpectateurs($scene["nb_max_spectateurs"] ?? self::DEFAULT_SPECTACLE_ILLUSTRATION_NAME);

            $sceneInstance
                ->setLatitude($scene["latitude_sc"]);

            $sceneInstance
                ->setLongitude($scene["longitude_sc"]);

            return $sceneInstance;
        }

        return null;
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
            $modelArray[] = self::getSceneById($line["id_scene"]);
        }

        return $modelArray;
    }
}