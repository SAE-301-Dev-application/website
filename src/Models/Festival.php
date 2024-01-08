<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Festival extends Model
{
    /** Festival's name */
    private string $name;

    /** Festival's description. */
    private string $description;

    /** Festival's beginning date. */
    private string $beginningDate;

    /** Festival's ending date. */
    private string $endingDate;

    /** Festival's categories */
    private array $categories;

    /** Festival's illustration */
    private string $illustration;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("festival");
    }

    /**
     * @return string Festival's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string Festival's description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string Festival's beginning date
     */
    public function getBeginningDate(): string
    {
        return $this->beginningDate;
    }

    /**
     * @return string Festival's ending date
     */
    public function getEndingDate(): string
    {
        return $this->endingDate;
    }

    /**
     * @return array Festival's categories
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return string Festival's illustration
     */
    public function getIllustration(): string
    {
        return $this->illustration;
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
        $illustrationPath = ROUTE_PATH_PREFIX
            . "src/Resources/Medias/Images/";
    
        $defaultIllustration = "default_illustration.png";

        return !$name || $name === $defaultIllustration
            ? $illustrationPath . $defaultIllustration
            : $illustrationPath . "FestivalsUploads/" . $name;
    }
}