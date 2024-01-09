<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Festival extends Model
{
    /** Default festival illustration path. */
    private const DEFAULT_FESTIVAL_ILLUSTRATION_PATH
        = ROUTE_PATH_PREFIX
        . "src/Resources/Medias/Images/default_illustration.png";

    /** Festival's id. */
    private int $id;

    /** Festival's name. */
    private string $name;

    /** Festival's description. */
    private string $description;

    /** Festival's beginning date. */
    private string $beginningDate;

    /** Festival's ending date. */
    private string $endingDate;

    /** Festival's illustration */
    private ?string $illustration;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("festival");
    }

    /**
     * @return int Festival's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id New festival's id
     * @return int New festival's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string Festival's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string Festival's description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string Festival's beginning date
     */
    public function getBeginningDate(): string
    {
        return $this->beginningDate;
    }

    /**
     * @param string $beginningDate
     */
    public function setBeginningDate(string $beginningDate): void
    {
        $this->beginningDate = $beginningDate;
    }

    /**
     * @return string Festival's ending date
     */
    public function getEndingDate(): string
    {
        return $this->endingDate;
    }

    /**
     * @param string $endingDate
     */
    public function setEndingDate(string $endingDate): void
    {
        $this->endingDate = $endingDate;
    }

    /**
     * @return array Festival's categories
     */
    public function getCategories(): array
    {
        return [];  // todo stump
    }

    /**
     * @return string Festival's illustration
     */
    public function getIllustration(): string
    {
        return $this->illustration;
    }

    /**
     * @param string|null $illustration
     */
    public function setIllustration(?string $illustration): void
    {
        $this->illustration = $illustration;
    }

    /**
     * Attempt to create a festival and link categories to it.
     *
     * @param string $name
     * @param string $description
     * @param string $illustration
     * @param string $beginningDate
     * @param string $endingDate
     * @param array $categories
     */
    public static function create(string $name,
                                  string $description,
                                  ?string $illustration,
                                  string $beginningDate,
                                  string $endingDate,
                                  array $categories): void
    {
        $addFestivalQuery = "SELECT ajouterFestival(?, ?, ?, ?, ?) AS id;";

        $linkCategorieQuery = "CALL ajouterFestivalCategorie(?, ?);";

        $festivalId = Database::query($addFestivalQuery,
                                      $name,
                                      $description,
                                      $illustration ?? null,
                                      $beginningDate,
                                      $endingDate);

        $festivalId = $festivalId->get()["id"];

        foreach ($categories as $categorie)
        {
            Database::query($linkCategorieQuery,
                            $festivalId,
                            $categorie);
        }
    }

    /**
     * Check if a festival exists.
     * 
     * @param string $name
     * @return bool True if the festival exists, false otherwise.
     */
    public static function isNameAlreadyTaken(string $name): bool
    {
        $checkNameQuery = "SELECT verifierFestivalExiste(?) AS resultat;";

        $result = Database::query($checkNameQuery, $name);

        return $result->get()["resultat"] === 1;
    }

    /**
     * Get all festivals.
     * 
     * @return array Festivals
     */
    public static function getFestivals(): array
    {
        $getFestivalsQuery
            = "SELECT *,
               CASE
                   WHEN CURRENT_DATE BETWEEN date_debut_fe AND date_fin_fe THEN 1
                   ELSE 0
               END AS en_cours_fe
               FROM festival;";

        $result = Database::query($getFestivalsQuery);

        return $result->getAll();
    }

    /**
     * Get path to a festival's illustration.
     * 
     * @param ?string $name
     * @return string Festival's illustration path
     */
    public static function getImagePathByName(?string $name)
    {
        // TODO: delete? !!
        $illustrationPath = ROUTE_PATH_PREFIX
            . "src/Resources/Medias/Images/";

        $defaultIllustration = "default_illustration.png";

        return !$name || $name === $defaultIllustration
            ? $illustrationPath . $defaultIllustration
            : $illustrationPath . "FestivalsUploads/" . $name;

    }

    /**
     * Searches and returns Festival instance by its id.
     *
     * @param int $id Festival id
     * @return Festival|null Festival object if exists;
     *                       else NULL
     */
    public static function getFestivalById(int $id): ?Festival
    {
        $query = "SELECT * FROM festival WHERE id_festival = ?";

        $getFestival = Database::query($query, $id);
        $festival = $getFestival->get();

        if ($festival)
        {
            $festivalInstance = new Festival();

            $festivalInstance
                ->setId($id);

            $festivalInstance
                ->setName($festival["nom_fe"]);

            $festivalInstance
                ->setDescription($festival["description_fe"]);

            $festivalInstance
                ->setBeginningDate($festival["date_debut_fe"]);

            $festivalInstance
                ->setEndingDate($festival["date_fin_fe"]);

            $festivalInstance
                ->setIllustration($festival["illustration_fe"] ?? self::DEFAULT_FESTIVAL_ILLUSTRATION_PATH);

            return $festivalInstance;
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
            $modelArray[] = self::getFestivalById($line["id_festival"]);
        }

        return $modelArray;
    }
}