<?php

namespace MvcLite\Models;

use JsonSerializable;
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
    private int $minDurationBetweenSpectacle;

    /** GriJ's id festival*/
    private int $idFestival;

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
     * @return int GriJ's minDurationBetweenSpectacle
     */
    public function getMinDurationBetweenSpectacle(): int
    {
        return $this->minDurationBetweenSpectacle;
    }

    /**
     * @param int $id New GriJ's minDurationBetweenSpectacle
     * @return int New GriJ's minDurationBetweenSpectacle
     */
    private function setMinDurationBetweenSpectacle(int $minDurationBetweenSpectacle): int
    {
        return $this->minDurationBetweenSpectacle = $minDurationBetweenSpectacle;
    }

    /**
     * @return int GriJ's idFestival
     */
    public function getIdFestival(): int
    {
        return $this->idFestival;
    }

    /**
     * @param int $id New GriJ's idFestival
     * @return int New GriJ's idFestival
     */
    private function setIdFestival(int $idFestival): int
    {
        return $this->idFestival = $idFestival;
    }

    /**
     * Attempt to create a GriJ.
     *
     * @param string $beginningSpectacleHour
     * @param string $endingSpectacleHour
     * @param string $minDurationBetweenSpectacle
     * @param string $minDurationBetweenSpectacle
     */
    public static function create(string $beginningSpectacleHour,
                                  string $endingSpectacleHour,
                                  string $minDurationBetweenSpectacle,
                                  string $idFestival): void
    {
        /* Créer la fonction ajouterGriJ */
        $addGriJQuery = "SELECT ajouterGriJ(?, ?, ?, ?) AS id;";

        $griJId = Database::query($addGriJQuery,
                                  $beginningSpectacleHour,
                                  $endingSpectacleHour,
                                  $minDurationBetweenSpectacle,
                                  $idFestival);
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
}