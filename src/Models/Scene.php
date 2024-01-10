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

    /* Scene's name */
    private string $name;

    /* Scene size, goes to 1 (Small), 2 (Medium) or 3 (Big) */
    private int $size;

    /* Maximum number of spectators in the scene */
    private int $maxSeats;

    /* Latitude coordinates of the scene */
    private string $latitude;

    /* Longitude coordinates of the scene */
    private string $longitude;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("scene");
    }

    /**
     * @return int Scene's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id Scene's id
     * @return int Scene's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string Scene's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name New Scene's name
     * @return string New Scene's name
     */
    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    /**
     * @return string Scene's size
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param string $size New Scene's size
     * @return int New Scene's size
     */
    public function setSize(int $size): int
    {
        return $this->size = $size;
    }

    /**
     * @return string Scene's maximum capacity of spectators
     */
    public function getMaxSeats(): int
    {
        return $this->maxSeats;
    }

    /**
     * @param string $maxSeats New Scene's maximum capacity of spectators
     * @return string New Scene's maximum capacity of spectators
     */
    public function setMaxSeats(int $maxSeats): int
    {
        return $this->maxSeats = $maxSeats;
    }

    /**
     * @return string Scene's latitude coordinates
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude New Scene's latitude coordinates
     * @return string New Scene's latitude coordinates
     */
    public function setLatitude(string $latitude): string
    {
        return $this->latitude = $latitude;
    }

    /**
     * @return string Scene's longitude coordinates
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude New Scene's longitude coordinates
     * @return string New Scene's longitude coordinates
     */
    public function setLongitude(string $longitude): string
    {
        return $this->longitude = $longitude;
    }

    /**
     * Attempt to create a scene with given information.
     *
     * @param string $nom
     * @param int $size
     * @param int $maxSeats
     * @param string $latitude
     * @param string $longitude
     * @return bool If the scene is being created
     */
    public static function create(string $nom,
                                  int $size,
                                  int $maxSeats,
                                  float $longitude,
                                  float $latitude): bool
    {
        $query = "CALL ajouterScene(?, ?, ?, ?, ?)";

        $user = Database::query($query,
                                $nom,
                                $size,
                                $maxSeats,
                                $latitude,
                                $longitude);

        return $user->getExecutionState();
    }

    /**
     * Searches and returns Scene instance by its id.
     *
     * @param int $id Scene id
     * @return Scene|null Scene object if exists;
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
                ->setSize($scene["taille_sc"]);

            $sceneInstance
                ->setMaxSeats($scene["nb_max_spectateurs"]);

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