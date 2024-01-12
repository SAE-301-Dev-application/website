<?php

namespace MvcLite\Models;

use JsonSerializable;
use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Models\Engine\Model;

class GriJ extends Model implements JsonSerializable
{
    /** GriJ's id. */
    private int $id;

    /** GriJ's beginning spectacle hour. */
    private string $beginningSpectacleHour;

    /** GriJ's ending spectacle hour. */
    private string $endingSpectacleHour;

    /** GriJ's min duration between spectacle. */
    private string $minDurationBetweenSpectacle;

    /** GriJ's id festival*/
    private int $festivalId;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("grij");
    }

    /**
     * @return int GriJ's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id New GriJ's id
     * @return int New GriJ's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return int GriJ's beginningSpectacleHour
     */
    public function getBeginningSpectacleHour(): string
    {
        return $this->beginningSpectacleHour;
    }

    /**
     * @param int $id New GriJ's beginningSpectacleHour
     * @return int New GriJ's beginningSpectacleHour
     */
    private function setBginningSpectacleHour(string $beginningSpectacleHour): string
    {
        return $this->beginningSpectacleHour = $beginningSpectacleHour;
    }

    /**
     * @return int GriJ's endingSpectacleHour
     */
    public function getEndingSpectacleHour(): string
    {
        return $this->endingSpectacleHour;
    }

    /**
     * @param int $id New GriJ's endingSpectacleHour
     * @return int New GriJ's endingSpectacleHour
     */
    private function setEndingSpectacleHour(string $endingSpectacleHour): string
    {
        return $this->endingSpectacleHour = $endingSpectacleHour;
    }

    /**
     * @return string GriJ's minDurationBetweenSpectacle
     */
    public function getMinDurationBetweenSpectacle(): string
    {
        return $this->minDurationBetweenSpectacle;
    }

    /**
     * @param string $id New GriJ's minDurationBetweenSpectacle
     * @return string New GriJ's minDurationBetweenSpectacle
     */
    private function setMinDurationBetweenSpectacle(string $minDurationBetweenSpectacle): string
    {
        return $this->minDurationBetweenSpectacle = $minDurationBetweenSpectacle;
    }

    /**
     * @return int GriJ's festivalId
     */
    public function getFestivalId(): int
    {
        return $this->festivalId;
    }

    /**
     * @param int $id New GriJ's festivalId
     * @return int New GriJ's festivalId
     */
    private function setFestivalId(int $festivalId): int
    {
        return $this->festivalId = $festivalId;
    }

    /**
     * @param int $festivalId id festival of GriJ
     * @return GriJ|null GriJ object if exists;
     *                       else NULL  
     */
    public static function getGriJByFestivalId(int $festivalId): ?GriJ
    {
        $query = "SELECT *
                  FROM grij
                  WHERE id_festival = ?";

        $getGriJ = Database::query($query, $festivalId);   
        $grij = $getGriJ->get();     

        if ($grij)
        {
            $grijInstance = new GriJ();

            $grijInstance
                ->setId($grij["id_grij"]);

            $grijInstance
                ->setBginningSpectacleHour($grij["heure_debut_spectacles"]);

            $grijInstance
                ->setEndingSpectacleHour($grij["heure_fin_spectacles"]);

            $grijInstance
                ->setMinDurationBetweenSpectacle($grij["duree_min_entre_spectacles"]);

            $grijInstance
                ->setFestivalId($festivalId);

            return $grijInstance;
        }

        return null;
    }



    /**
     * Attempt to create a GriJ.
     *
     * @param string $beginningSpectacleHour
     * @param string $endingSpectacleHour
     * @param string $minDurationBetweenSpectacle
     * @param string $festivalId
     */
    public static function create(string $beginningSpectacleHour,
                                  string $endingSpectacleHour,
                                  string $minDurationBetweenSpectacle,
                                  string $festivalId): void
    {
        /* Créer la fonction ajouterGriJ */
        $addGriJQuery = "SELECT ajouterGriJ(?, ?, ?, ?);";

        $griJId = Database::query($addGriJQuery,
                                  $beginningSpectacleHour,
                                  $endingSpectacleHour,
                                  $minDurationBetweenSpectacle,
                                  $festivalId);
    }

    /**
     * Returns GriJ array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array GriJ array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];

        foreach($queryObject->getAll() as $griJ)
        {
            $modelArray[] = self::getFestivalInstance($griJ);
        }

        return $modelArray;
    }

    /**
     * @return array JSON serializing original array
     */
    public function jsonSerialize(): array
    {
        return [
            "id_grij" => $this->getId(),
            "heure_debut_spectacles" => $this->getBeginningSpectacleHour(),
            "heure_fin_spectacles" => $this->getEndingSpectacleHour(),
            "duree_min_entre_spectacles" => $this->getMinDurationBetweenSpectacle(),
            "id_festival" => $this->getFestivalId(),
        ];
    }
}