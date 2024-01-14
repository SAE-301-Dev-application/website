<?php

namespace MvcLite\Models;

use JsonSerializable;
use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;

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
     * @param int $limit Limit row returned
     * @return array Festival's spectacles with limit
     */
    public function getSpectaclesWithLimit(int $limit): array
    {
        $getSpectaclesQuery
            = "SELECT sp.*
               FROM spectacle sp 
               INNER JOIN festival_spectacle fs
               ON sp.id_spectacle = fs.id_spectacle
               WHERE fs.id_festival = ?
               LIMIt ?;";

        $result = Database::query($getSpectaclesQuery, $this->getId(), $limit);

        return Spectacle::queryToArray($result);
    }

    /**
     * @return GriJ|null GriJ object if exists;
     *                       else NULL  
     */
    public function getGriJWithId(): array
    {
        $query = "SELECT *
                  FROM grij
                  WHERE id_festival = ?";

        $getGriJ = Database::query($query, $this->getId());
        
        return GriJ::queryToArray($getGriJ);  

    }

    /**
     * @param Spectacle $spectacle Searched spectacle object
     * @return bool If given spectacle is used by current festival
     */
    public function hasSpectacle(Spectacle $spectacle): bool
    {
        $query = "SELECT COUNT(*) as count
                  FROM festival
                  INNER JOIN festiplan.festival_spectacle fs on festival.id_festival = fs.id_festival
                  WHERE festival.id_festival = ? 
                  AND fs.id_spectacle = ?";

        $spectacleRemoving = Database::query($query, $this->getId(), $spectacle->getId());

        return $spectacleRemoving->get()["count"];
    }

    /**
     * Attempt to add a spectacle in a festival.
     *
     * @param int $idSpectacle
     */
    public function addSpectacle(Spectacle $spectacle)
    {

        $addFestivalQuery = "CALL ajouterFestivalSpectacle(?, ?);";

        $spectacleAdding = Database::query($addFestivalQuery,
                                           $this->getId(),
                                           $spectacle->getId());

        return $spectacleAdding->getExecutionState();
    }

    /**
     * Removes given spectacle from current festival.
     *
     * @param Spectacle $spectacle
     * @return bool If spectacle has been removed from festival
     */
    public function removeSpectacle(Spectacle $spectacle): bool
    {
        $query = "DELETE FROM festival_spectacle
                  WHERE id_festival = ?
                  AND id_spectacle = ?";

        $spectacleRemoving = Database::query($query, $this->getId(), $spectacle->getId());

        return $spectacleRemoving->getExecutionState();
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
     * @param int $limit Limit row returned
     * @return array Festival's scenes with limit
     */
    public function getScenesWithLimit(int $limit): array
    {
        $query
            = "SELECT sc.*
               FROM scene sc
               INNER JOIN festival_scene fs
               ON sc.id_scene = fs.id_scene
               WHERE fs.id_festival = ?
               LIMIt ?;";

        $result = Database::query($query, $this->getId(), $limit);

        return Scene::queryToArray($result);
    }

    /**
     * @return array Festival's organizers
     */
    public function getOrganizers(): array
    {

        $getOwnerQuery
            = "SELECT ut.*
               FROM festival fe
               INNER JOIN utilisateur ut
               ON fe.id_createur = ut.id_utilisateur
               WHERE fe.id_festival = ?";

        $getOrganizersQuery
            = "SELECT ut.*
               FROM utilisateur ut
               INNER JOIN festival_utilisateur fu
               ON ut.id_utilisateur = fu.id_utilisateur
               WHERE id_festival = ?";


        $resultOwner = Database::query($getOwnerQuery, $this->getId());
        $resultOrga = Database::query($getOrganizersQuery, $this->getId());

        $result = array_merge(User::queryToArray($resultOwner), User::queryToArray($resultOrga));

        return $result;
    }

    /**
     * @param int $limit Limit row returned
     * @return array Festival's organizers with limit
     */
    public function getOrganizersWithLimit(int $limit): array
    {
        $query
            = "SELECT *
               FROM utilisateur ut
               INNER JOIN festival_utilisateur fu
               ON ut.id_utilisateur = fu.id_utilisateur
               WHERE id_festival = ?
               LIMIt ?;";

        $result = Database::query($query, $this->getId(), $limit);

        return User::queryToArray($result);
    }

    /**
     * Adds a user as organizer.
     *
     * @param int $idUser
     */
    public function addOrganizer(User $user): bool
    {

        $addFestivalQuery = "CALL ajouterFestivalUtilisateur(?, ?);";

        $organizerAdding = Database::query($addFestivalQuery,
            $this->getId(),
            $user->getId());

        return $organizerAdding->getExecutionState();
    }

    /**
     * @return bool True if the festival is in progress, false otherwise.
     */
    public function isInProgress(): bool
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
                                                   string $endingDate,
                                                   array $checkedCategories): void
    {
        $addFestivalQuery = "CALL modifierFestival(?, ?, ?, ?, ?, ?);";

        $linkCategoryQuery = "CALL ajouterFestivalCategorie(?, ?);";

        $festivalId = Database::query($addFestivalQuery,
                                      $name,
                                      $description,
                                      $illustration ?? null,
                                      $beginningDate,
                                      $endingDate,
                                      Session::getUserAccount()->getId());

        $festivalId = $festivalId->get()["id"];

        foreach ($categories as $categorie)
        {
            Database::query($linkCategoryQuery,
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
     * @param User $user Searched user object
     * @return bool If given user is an organizer of current festival
     */
    public function hasOrganizer(User $user): bool
    {
        $query = "SELECT COUNT(*) as count
                  FROM utilisateur
                  INNER JOIN festiplan.festival f on utilisateur.id_utilisateur = f.id_createur
                  WHERE f.id_festival = ? 
                  AND utilisateur.id_utilisateur = ?";

        $sceneRemoving = Database::query($query, $this->getId(), $user->getId());

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
        $query = "CALL ajouterFestivalScene(?, ?);";

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
    public function lastFestivals(): array
    {
        $query = "SELECT *
                  FROM festival
                  WHERE date_debut_fe <= CURDATE()
                  LIMIT 3;";
        
        $threeLastFestivals = Database::query($query);

        return Festival::queryToArray($threeLastFestivals);
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
     * Attempts to delete a festival by its id.
     *
     * @return bool If festival is successfully deleted
     */
    public function delete(): bool
    {
        $query = "DELETE FROM festival WHERE id_festival = ?";

        $festivalDeleting = Database::query($query, $this->getId());

        return $festivalDeleting->getExecutionState();
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