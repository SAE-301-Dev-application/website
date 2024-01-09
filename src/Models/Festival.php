<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Festival extends Model
{
    /** Default festival illustration path. */
    private const DEFAULT_FESTIVAL_ILLUSTRATION_PATH
        = "default_illustration.png";

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
     * @return string Festival's illustration
     */
    public function getIllustration(): string
    {
        return Storage::getResourcesPath() . "/Medias/Images/FestivalsUploads/" . $this->illustration;
    }

    /**
     * @param string|null $illustration
     */
    public function setIllustration(?string $illustration): void
    {
        $this->illustration = $illustration;
    }

    /**
     * @return array Festival's categories
     */
    public function getCategories(): array
    {

        $getCategoriesQuery
            = "SELECT DISTINCT id_categorie
               FROM festival_categorie
               WHERE id_festival = ?
               ORDER BY id_categorie;";

        $result = Database::query($getCategoriesQuery, $id);

        return $result->getAll();
    }

    /**
     * @return array Festival's spectacles
     */
    public function getSpectacles(): array
    {

        $getSpectaclesQuery
            = "SELECT DISTINCT id_spectacle
               FROM festival_spectacle
               WHERE id_festival = ?
               ORDER BY id_spectacle;";

        $result = Database::query($getSpectaclesQuery, $id);

        return $result->getAll();
    }

    /**
     * @return array Festival's scenes
     */
    public function getScenes(): array
    {

        $getSpectaclesQuery
            = "SELECT DISTINCT id_scene
               FROM festival_scene
               WHERE id_festival = ?
               ORDER BY id_scene;";

        $result = Database::query($getSpectaclesQuery, $id);

        return $result->getAll();
    }

    /**
     * @return array Festival's scenes
     */
    public function getUtilisateurs(): array
    {

        $getSpectaclesQuery
            = "SELECT DISTINCT id_utilisateur, role_uti
               FROM festival_utilisateur
               WHERE id_festival = ?
               ORDER BY id_utilisateur, role_uti;";

        $result = Database::query($getSpectaclesQuery, $id);

        return $result->getAll();
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
     * Attempt to modify a festival's generals parameters 
     * and relink categories to it.
     *
     * @param string $name
     * @param string $description
     * @param string $illustration
     * @param string $beginningDate
     * @param string $endingDate
     * @param array $categories
     */
    public static function modifyGeneralParameters(int $id,
                                                   string $name,
                                                   string $description,
                                                   ?string $illustration,
                                                   string $beginningDate,
                                                   string $endingDate): void
    {
        $addFestivalQuery = "SELECT modifierFestival(?, ?, ?, ?, ?) AS id;";

        $linkCategorieQuery = "CALL ajouterFestivalCategorie(?, ?);";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
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
     * Attempt to add users as the ones who are responsible or who 
     * organize a festival.
     *
     * @param int $id
     * @param int $idUser
     * @param string $role
     */
    public static function ajouterRolesUtilisateurs(int $id,
                                                    int $idUser,
                                                    int $role)
    {

        $addFestivalQuery = "SELECT ajouterFestivalUtilisateur(?, ?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idUser,
                                      $role);

    }

    /**
     * Attempt to modify the roles of the users who
     * are responsible or who organize a festival.
     *
     * @param int $id
     * @param int $idUser
     * @param string $role
     */
    public static function modifierRolesUtilisateurs(int $id,
                                                     int $idUser,
                                                     int $role)
    {

        $addFestivalQuery = "SELECT ajouterFestivalOrganisateurs(?, ?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idUser,
                                      $role);

    }

    /**
     * Attempt to delete an user from the one who are
     * responsible or who organiize a festival.
     *
     * @param int $id
     * @param int $idUser
     * @param string $role
     */
    public static function supprimerRolesUtilisateurs(int $id,
                                                      int $idUser,
                                                      int $role)
    {

        $addFestivalQuery = "SELECT ajouterFestivalOrganisateurs(?, ?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idUser,
                                      $role);

    }

    /**
     * Attempt to add a spectacle in a festival.
     *
     * @param int $id
     * @param int $idSpectacle
     */
    public static function ajouterSpectacle(int $id,
                                            int $idSpectacle)
    {

        $addFestivalQuery = "SELECT ajouterFestivalSpectacle(?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idSpectacle);

    }

    /**
     * Attempt to delete a spectacle from a festival.
     *
     * @param int $id
     * @param int $idSpectacle
     */
    public static function supprimerSpectacle(int $id,
                                              int $idSpectacle)
    {

        $addFestivalQuery = "SELECT supprimerFestivalSpectacle(?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idSpectacle);

    }

    /**
     * Attempt to add a scene in a festival.
     *
     * @param int $id
     * @param int $idSpectacle
     */
    public static function ajouterScene(int $id,
                                        int $idScene)
    {

        $addFestivalQuery = "SELECT ajouterFestivalScene(?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idScene);

    }

    /**
     * Attempt to delete a scene from a festival.
     *
     * @param int $id
     * @param int $idSpectacle
     */
    public static function supprimerScene(int $id,
                                          int $idScene)
    {

        $addFestivalQuery = "SELECT supprimerFestivalScene(?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $idScene);

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
               FROM festival
               ORDER BY en_cours_fe DESC, date_debut_fe ASC, date_fin_fe ASC;";

        $result = Database::query($getFestivalsQuery);

        return Festival::queryToArray($result);
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
                ->setIllustration($festival["illustration_fe"]);

            return $festivalInstance;
        }

        return null;
    }

    /**
     * Searches and returns Festival instance by its name.
     *
     * @param string $nom Festival name
     * @return Festival|null Festival object if exists;
     *                       else NULL
     */
    public static function getFestivalByName(string $nom): ?Festival
    {
        $query = "SELECT * FROM festival WHERE nom_fe = ?";

        $getFestival = Database::query($query, $nom);
        $festival = $getFestival->get();

        if ($festival)
        {
            $festivalInstance = new Festival();

            $festivalInstance
                ->setId($festival["nom_fe"]);

            $festivalInstance
                ->setName($nom);

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