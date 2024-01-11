<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;

class Contributor extends Model
{
    public const FIRSTNAME_MAX_LENGTH = 25;

    public const FIRSTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,25}$/u";

    public const LASTNAME_MAX_LENGTH = 50;

    public const LASTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,50}$/u";

    public const EMAIL_MIN_LENGTH = 5;

    public const EMAIL_MAX_LENGTH = 255;

    /** User id. */
    private int $id;

    /** User lastname */
    private string $lastname;

    /** User firstname. */
    private string $firstname;

    /** User email address. */
    private string $email;

    public function __construct()
    {
        parent::__construct();

        $this->setId(0);
        $this->setFirstname("None");
        $this->setLastname("None");
        $this->setEmail("None");

        $this->setTableName("intervenant");
    }

    /**
     * @return int User id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id User id
     * @return int User id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string User lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname New lastname
     * @return string New lastname
     */
    public function setLastname(string $lastname): string
    {
        return $this->lastname = $lastname;
    }

    /**
     * @return string User firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname New firstname
     * @return string New firstname
     */
    public function setFirstname(string $firstname): string
    {
        return $this->firstname = $firstname;
    }

    /**
     * @return string User email address
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email New email address
     * @return string New email address
     */
    public function setEmail(string $email): string
    {
        return $this->email = $email;
    }

    /**
     * @return DatabaseQuery User's spectacles
     */
    public function getContributorSpectacles(): DatabaseQuery
    {
        $query = "SELECT *
                  FROM spectacle
                  INNER JOIN spectacle_intervenant si
                      on spectacle.id_spectacle = si.id_spectacle
                  WHERE si.id_intervenant = ?";

        $spectacles = Database::query($query, $this->getId());

        return $spectacles;
    }

    /**
     * Searches and returns Contributor instance by its data.
     *
     * @param array $contributorData Contributor data
     * @return Contributor Contributor object
     */
    public static function getContributorInstance(array $contributorData): Contributor
    {
        $contributorInstance = new Contributor();
        $contributorInstance->setId($contributorData["id_intervenant"]);
        $contributorInstance->setLastname($contributorData["nom_inter"]);
        $contributorInstance->setFirstname($contributorData["prenom_inter"]);
        $contributorInstance->setEmail($contributorData["email_inter"]);

        return $contributorInstance;
    }

    /**
     * Searches and returns Contributor instance by its id.
     *
     * @param int $id Contributor id
     * @return Contributor|null Contributor object if exists;
     *                   else NULL
     */
    public static function getContributorById(int $id): ?Contributor
    {
        $query = "SELECT * FROM intervenant WHERE id_intervenant = ?";

        $getContributor = Database::query($query, $id);
        $contributor = $getContributor->get();

        if ($contributor)
        {
            $contributorInstance = new Contributor();
            $contributorInstance->setId($id);
            $contributorInstance->setLastname($contributor["nom_inter"]);
            $contributorInstance->setFirstname($contributor["prenom_inter"]);
            $contributorInstance->setEmail($contributor["email_inter"]);

            return $contributorInstance;
        }

        return null;
    }

    /**
     * Returns Contributor array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array contributor array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];
        
        foreach($queryObject->getAll() as $contributor)
        {
            $modelArray[] = self::getContributorInstance($contributor);
        }

        return $modelArray;
    }
}