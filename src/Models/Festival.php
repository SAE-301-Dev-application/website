<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Spectacle;
use MvcLite\Models\Scene;

class Festival extends Model
{
    /** Default festival illustration name. */
    public const DEFAULT_FESTIVAL_ILLUSTRATION_NAME
        = "default_illustration.png";

    /** Default festival illustration path. */
    public const DEFAULT_FESTIVAL_ILLUSTRATION_PATH
        = ROUTE_PATH_PREFIX . "src/Resources/Medias/Images/";

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

    /** Festival's illustration. */
    private ?string $illustration;

    /** Festival's owner. */
    private User $owner;

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
        return self::DEFAULT_FESTIVAL_ILLUSTRATION_PATH
               . ($this->illustration === self::DEFAULT_FESTIVAL_ILLUSTRATION_NAME
                      ? ""
                      : "FestivalsUploads/")
               . $this->illustration;
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

        $result = Database::query($getCategoriesQuery, $this->getId());

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
               WHERE id_festival = ?;";

        $result = Database::query($getSpectaclesQuery, $this->getId());

        return Spectacle::queryToArray($result);
    }

    /**
     * Attempt to add a spectacle in a festival.
     *
     * @param int $id
     * @param int $idSpectacle
     */
    public function addSpectacle(Spectacle $spectacle)
    {

        $addFestivalQuery = "SELECT ajouterFestivalSpectacle(?, ?) AS id;";

        $spectacleAdding = Database::query($addFestivalQuery,
                                           $this->getId(),
                                           $spectacle->getId());

    }

    /**
     * @return array Festival's scenes
     */
    public function getScenes(): array
    {

        $getSpectaclesQuery
            = "SELECT DISTINCT id_scene
               FROM festival_scene
               WHERE id_festival = ?;";

        $result = Database::query($getSpectaclesQuery, $this->getId());

        return Scene::queryToArray($result);
    }

    /**
     * @return array Festival's scenes
     */
    public function getOrganizers(): array
    {

        $getUsersQuery
            = "SELECT DISTINCT id_utilisateur
               FROM festival_utilisateur
               WHERE id_festival = ?";

        $result = Database::query($getUsersQuery, $this->getId());

        return User::queryToArray($result);
    }

    /**
     * Adds a user as organizer.
     *
     * @param int $idUser
     */
    public function addOrganizer(User $user)
    {

        $addFestivalQuery = "SELECT ajouterFestivalUtilisateur(?, ?) AS id;";

        $festivalId = Database::query($addFestivalQuery,
            $this->getId(),
            $user->getId());
    }

    /**
     * @return User Festival's owner
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @param User $owner New festival's owner
     * @return User New festival's owner
     */
    public function setOwner(User $owner): User
    {
        return $this->owner = $owner;
    }

    /**
     * @return bool True if the festival is in progress, false otherwise.
     */
    public function isFestivalInProgress(): bool
    {
        $now = time();
        return $now >= strtotime($this->beginningDate) && $now <= strtotime($this->endingDate);
    }

    /**
     * Attempt to create a festival and link categories to it.
     *
     * @param string $name
     * @param string $description
     * @param string|null $illustration
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
        $addFestivalQuery = "SELECT ajouterFestival(?, ?, ?, ?, ?, ?) AS id;";

        $linkCategoryQuery = "CALL ajouterFestivalCategorie(?, ?);";

        $festivalId = Database::query($addFestivalQuery,
                                      $name,
                                      $description,
                                      $illustration ?? null,
                                      $beginningDate,
                                      $endingDate,
                                      Session::getSessionId());

        $festivalId = $festivalId->get()["id"];

        foreach ($categories as $category)
        {
            Database::query($linkCategoryQuery,
                            $festivalId,
                            $category);
        }
    }

    /**
     * Attempt to modify a festival's generals parameters
     * and relink categories to it.
     *
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string|null $illustration
     * @param string $beginningDate
     * @param string $endingDate
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

    // TODO lecture

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
     * @return DatabaseQuery All festivals DatabaseQuery object
     */
    public static function getFestivals(): DatabaseQuery
    {
        $getFestivalsQuery
            = "SELECT *,
               CASE
                   WHEN CURRENT_DATE BETWEEN date_debut_fe AND date_fin_fe THEN 1
                   ELSE 0
               END AS en_cours_fe
               FROM festival
               ORDER BY en_cours_fe DESC, date_debut_fe ASC, date_fin_fe ASC;";

        return Database::query($getFestivalsQuery);
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
                ->setIllustration($festival["illustration_fe"] ?? self::DEFAULT_FESTIVAL_ILLUSTRATION_NAME);

            $festivalInstance
                ->setOwner(User::getUserById($festival["id_createur"]));

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
                ->setIllustration($festival["illustration_fe"] ?? self::DEFAULT_FESTIVAL_ILLUSTRATION_NAME);

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