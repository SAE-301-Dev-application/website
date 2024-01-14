<?php

namespace MvcLite\Models;

use JsonSerializable;
use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
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
     * @return int GriJ's beginningSpectacleHour with format
     */
    public function getBeginningSpectacleHourWithFormat(string $format): string
    {
        $query = "SELECT TIME_FORMAT(heure_debut_spectacles, '$format') AS formatted_heure_debut
                  FROM grij
                  WHERE id_grij = ?";
                  
        $result = Database::query($query, $this->getId());

        return $result->get()["formatted_heure_debut"];
    }

    /**
     * @param int $id New GriJ's beginningSpectacleHour
     * @return int New GriJ's beginningSpectacleHour
     */
    private function setBeginningSpectacleHour(string $beginningSpectacleHour): string
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
     * @return int GriJ's endingSpectacleHour with format
     */
    public function getEndingSpectacleHourWithFormat(string $format): string
    {
        $query = "SELECT TIME_FORMAT(heure_fin_spectacles, '$format') AS formatted_heure_fin
                  FROM grij
                  WHERE id_grij = ?";
                  
        $result = Database::query($query, $this->getId());

        return $result->get()["formatted_heure_fin"];
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
     * @return int GriJ's minDurationBetweenSpectacle with format
     */
    public function getMinDurationBetweenSpectacleWithFormat(string $format): string
    {
        $query = "SELECT TIME_FORMAT(duree_min_entre_spectacles, '$format') AS formatted_duree_min
                  FROM grij
                  WHERE id_grij = ?";
                  
        $result = Database::query($query, $this->getId());

        return $result->get()["formatted_duree_min"];
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
        $addGriJQuery = "CALL ajouterGriJ(?, ?, ?, ?);";

        $griJId = Database::query($addGriJQuery,
                                  $beginningSpectacleHour,
                                  $endingSpectacleHour,
                                  $minDurationBetweenSpectacle,
                                  $festivalId);
    }

    /**
     * Searches and returns GriJ instance by its data.
     *
     * @param array $grijData GriJ data
     * @return GriJ GriJ object
     */
    public static function getGriJInstance(array $grijData): GriJ
    {
        $griJInstance = new GriJ();

        $griJInstance
            ->setId($grijData["id_grij"]);

        $griJInstance
            ->setBeginningSpectacleHour($grijData["heure_debut_spectacles"]);

        $griJInstance
            ->setEndingSpectacleHour($grijData["heure_fin_spectacles"]);

        $griJInstance
            ->setMinDurationBetweenSpectacle($grijData["duree_min_entre_spectacles"]);

        $griJInstance
            ->setFestivalId($grijData["id_festival"]);

        return $griJInstance;
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