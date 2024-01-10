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
    public function getSpectacles(): DatabaseQuery
    {
        $query = "SELECT *
                  FROM spectacle
                  INNER JOIN spectacle_intervenant si
                      on spectacle.id_spectacle = si.id_spectacle
                  WHERE si.id_intervenant = ?";

        $spectacles = Database::query($query, $this->getId());

        return $spectacles;
    }

    // A MODIFIER
    // /**
    //  * Delete current user account.
    //  * 
    //  * @return bool If the account is being deleted
    //  */
    // public function delete(): bool
    // {
    //     $query = "CALL supprimerUtilisateur(?);";

    //     $deletion = Database::query($query, $this->getId());

    //     return $deletion->getExecutionState();
    // }

    // A MODIFIER
    // /**
    //  * Attempt to create an account with given information.
    //  *
    //  * @param string $name
    //  * @param string $firstname
    //  * @param string $email
    //  * @return bool If the account is being created
    //  */
    // public static function create(string $name,
    //                               string $firstname,
    //                               string $email): bool
    // {
    //     $query = "CALL ajouterUtilisateur(?, ?, ?);";

    //     $user = Database::query($query,
    //                             $name,
    //                             $firstname,
    //                             $email);

    //     return $user->getExecutionState();
    // }

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
        
        while ($line = $queryObject->get())
        {
            $modelArray[] = self::getContributorById($line["id_intervenant"]);
        }

        return $modelArray;
    }
}