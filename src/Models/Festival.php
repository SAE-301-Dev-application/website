<?php

namespace MvcLite\Models;

use JsonSerializable;
use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Scene;
use MvcLite\Models\Spectacle;

class Festival extends Model implements JsonSerializable
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
     * @param format format of date
     * @return string date with format of date
     */
    public function getBeginningDateWithFormat(string $format): string
    {
        $query = "SELECT DATE_FORMAT(date_debut_fe, '$format') AS formatted_date_debut
                  FROM festival
                  WHERE id_festival = ?";
        
        $result = Database::query($query, $this->getId());

        return $result->get()["formatted_date_debut"];
    }
   
    /**
     * @param format format of date
     * @return string date with format of date
     */
    public function getEndingDateWithFormat(string $format): string
    {
        $query = "SELECT DATE_FORMAT(date_fin_fe, '$format') AS formatted_date_fin
                  FROM festival
                  WHERE id_festival = ?";
        
        $result = Database::query($query, $this->getId());

        return $result->get()["formatted_date_fin"];
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
     * @return string Festival's owner
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return bool If the current user are Owner of this festival
     */
    public function isUserOwner(): bool
    {
        return Session::getUserAccount() == User::getUserById($this->getOwner()->getId());
    }

    /**
     * @param string $owner
     */
    public function setOwner(int $owner): void
    {
        $this->owner = User::getUserById($owner);
    }

    /**
     * @return array Festival's categories
     */
    public function getCategories(): array
    {

        $getCategoriesQuery
            = "SELECT ca.*
               FROM categorie ca
               INNER JOIN festival_categorie fc
               ON ca.id_categorie = fc.id_categorie
               WHERE fc.id_festival = ?";

        $result = Database::query($getCategoriesQuery, $this->getId());

        return Category::queryToArray($result);
    }

    /**
     * @return array Festival's spectacles
     */
    public function getSpectacles(): array
    {
        $getSpectaclesQuery
            = "SELECT sp.*
               FROM spectacle sp 
               INNER JOIN festival_spectacle fs
               ON sp.id_spectacle = fs.id_spectacle
               WHERE fs.id_festival = ?;";

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

        $getScenesQuery
            = "SELECT sc.*
               FROM scene sc
               INNER JOIN festival_scene fs
               ON sc.id_scene = fs.id_scene
               WHERE fs.id_festival = ?;";

        $result = Database::query($getScenesQuery, $this->getId());

        return Scene::queryToArray($result);
    }

    /**
     * @return array Festival's scenes
     */
    public function getOrganizers(): array
    {

        $getUsersQuery
            = "SELECT *
               FROM utilisateur ut
               INNER JOIN festival_utilisateur fu
               ON ut.id_utilisateur = fu.id_utilisateur
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
                                      Session::getUserAccount()->getId());

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
    public static function modifyGeneralParameters(string $name,
                                                   string $description,
                                                   ?string $illustration,
                                                   string $beginningDate,
                                                   string $endingDate): void
    {
        $addFestivalQuery = "SELECT modifierFestival(?, ?, ?, ?, ?, ?) AS id;";

        $linkCategoryQuery = "CALL ajouterFestivalCategorie(?, ?);";

        $festivalId = Database::query($addFestivalQuery,
                                      $id,
                                      $name,
                                      $description,
                                      $illustration ?? null,
                                      $beginningDate,
                                      $endingDate,
                                      $this->owner);

        $festivalId = $festivalId->get()["id"];

        foreach ($categories as $categorie)
        {
            Database::query($linkCategoryQuery,
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
     * Searches and returns Festival instance by its data.
     *
     * @param array $festivalData Festival data
     * @return Festival Festival object
     */
    public static function getFestivalInstance(array $festivalData): Festival
    {
        $festivalInstance = new Festival();

        $festivalInstance
            ->setId($festivalData["id_festival"]);

        $festivalInstance
            ->setName($festivalData["nom_fe"]);

        $festivalInstance
            ->setDescription($festivalData["description_fe"]);

        $festivalInstance
            ->setBeginningDate($festivalData["date_debut_fe"]);

        $festivalInstance
            ->setEndingDate($festivalData["date_fin_fe"]);

        $festivalInstance
            ->setIllustration($festivalData["illustration_fe"] ?? self::DEFAULT_FESTIVAL_ILLUSTRATION_NAME);

        $festivalInstance
            ->setOwner($festivalData["id_createur"]);

        return $festivalInstance;
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
                ->setOwner($festival["id_createur"]);

            return $festivalInstance;
        }

        return null;
    }

    /**
     * @param Scene $scene Searched scene object
     * @return bool If given scene is used by current festival
     */
    public function hasScene(Scene $scene): bool
    {
        $query = "SELECT COUNT(*) as count
                  FROM festival
                  INNER JOIN festiplan.festival_scene fs on festival.id_festival = fs.id_festival
                  WHERE festival.id_festival = ? 
                  AND fs.id_scene = ?";

        $sceneRemoving = Database::query($query, $this->getId(), $scene->getId());

        return $sceneRemoving->get()["count"];
    }

    /**
     * Adds given scene from current festival.
     *
     * @param Scene $scene
     * @return bool If scene has been removed from festival
     */
    public function addScene(Scene $scene): bool
    {
        $query = "INSERT INTO festival_scene
                  (id_festival, id_scene) 
                  VALUES (?, ?)";

        $sceneRemoving = Database::query($query, $this->getId(), $scene->getId());

        return $sceneRemoving->getExecutionState();
    }

    /**
     * Removes given scene from current festival.
     *
     * @param Scene $scene
     * @return bool If scene has been removed from festival
     */
    public function removeScene(Scene $scene): bool
    {
        $query = "DELETE FROM festival_scene
                  WHERE id_festival = ?
                  AND id_scene = ?";

        $sceneRemoving = Database::query($query, $this->getId(), $scene->getId());

        return $sceneRemoving->getExecutionState();
    }

    /**
     * @return array Three last id of festivals 
     */
    public static function lastFestivals(): array
    {
        $query = "SELECT id_festival
                  FROM festival
                  WHERE date_debut_fe <= CURDATE()
                  LIMIT 3;";
        
        $threeLastFestivals = Database::query($query);

        return $threeLastFestivals->getAll();
    }

    /**
     * Searches and returns grij by festival id.
     */
    public static function getGrij(int $idFestival): array
    {
        $query = "SELECT *
                  FROM grij
                  WHERE id_festival = ?";

        $getGrij = Database::query($query, $idFestival);

        return $getGrij->get();
    }

    /**
     * Returns Festival array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array festival array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];

        foreach($queryObject->getAll() as $festival)
        {
            $modelArray[] = self::getFestivalInstance($festival);
        }

        return $modelArray;
    }

    /**
     * @return array JSON serializing original array
     */
    public function jsonSerialize(): array
    {
        return [
            "id_festival" => $this->getId(),
            "nom_fe" => $this->getName(),
            "description_fe" => $this->getDescription(),
            "illustration_fe" => $this->getIllustration(),
            "date_debut_fe" => $this->getBeginningDate(),
            "date_fin_fe" => $this->getEndingDate(),
            "id_createur" => $this->getOwner()->getId(),
        ];
    }
}