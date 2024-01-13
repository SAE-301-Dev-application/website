<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;
use MvcLite\Models\Spectacle;
use MvcLite\Models\Festival;

class User extends Model
{
    public const FIRSTNAME_MAX_LENGTH = 25;

    public const FIRSTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,25}$/u";

    public const LASTNAME_MAX_LENGTH = 50;

    public const LASTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,50}$/u";

    public const LOGIN_MIN_LENGTH = 3;

    public const LOGIN_MAX_LENGTH = 25;

    public const EMAIL_MIN_LENGTH = 5;

    public const EMAIL_MAX_LENGTH = 255;

    public const PASSWORD_MIN_LENGTH = 8;

    /** User id. */
    private int $id;

    /** User lastname */
    private string $lastname;

    /** User firstname. */
    private string $firstname;

    /** User email address. */
    private string $email;

    /** User login. */
    private string $login;

    /** User password. */
    private string $password;

    public function __construct()
    {
        parent::__construct();

        $this->setId(0);
        $this->setFirstname("None");
        $this->setLastname("None");
        $this->setLogin("None");
        $this->setEmail("None");
        $this->setPassword("None");

        $this->setTableName("utilisateur");
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
     * @return string User login
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login New login
     * @return string New login
     */
    public function setLogin(string $login): string
    {
        return $this->login = $login;
    }

    /**
     * @return string User login
     */
    private function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password New password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return array User's festivals
     */
    public function getFestivals(): array
    {
        $query = "SELECT f.id_festival,f.nom_fe,f.description_fe,
                  f.illustration_fe,f.date_debut_fe,f.date_fin_fe,f.id_createur 
                  FROM festival f 
                  LEFT OUTER JOIN festival_utilisateur fu
                  ON f.id_festival = fu.id_festival 
                  WHERE fu.id_utilisateur = ? 
                  OR f.id_createur = ?;";

        $festivals = Database::query($query, $this->getId(), $this->getId());

        return Festival::queryToArray($festivals);
    }

    /**
     * @return array User's spectacles instances
     */
    public function getUserSpectacles(): array
    {
        $query = "SELECT *
                  FROM spectacle
                  WHERE id_createur = ?;";

        $spectacles = Database::query($query, $this->getId());

        return Spectacle::queryToArray($spectacles);
    }

    /**
     * Verify given password with session user one.
     *
     * @param string $password Given password
     * @return bool If given password is the good one
     */
    public function verifyPassword(string $password): bool
    {
        return Password::verify($password, $this->getPassword());
    }

    public function save(): bool
    {
        $query = "UPDATE utilisateur
                  SET prenom_uti = ?,
                      nom_uti = ?,
                      email_uti = ?,
                      login_uti = ?,
                      mdp_uti = ?
                  WHERE id_utilisateur = ?;";

        $userSaving = Database::query($query,
                                      $this->getFirstname(),
                                      $this->getLastname(),
                                      $this->getEmail(),
                                      $this->getLogin(),
                                      $this->getPassword(),
                                      $this->getId());

        return $userSaving->getExecutionState();
    }

    /**
     * Delete current user account.
     * 
     * @return bool If the account is being deleted
     */
    public function delete(): bool
    {
        $query = "CALL supprimerUtilisateur(?);";

        $deletion = Database::query($query, $this->getId());

        return $deletion->getExecutionState();
    }

    /**
     * Attempt to create an account with given information.
     *
     * @param string $name
     * @param string $firstname
     * @param string $email
     * @param string $login
     * @param string $hash
     * @return bool If the account is being created
     */
    public static function create(string $name,
                                  string $firstname,
                                  string $email,
                                  string $login,
                                  string $hash): bool
    {
        $query = "CALL ajouterUtilisateur(?, ?, ?, ?, ?);";

        $user = Database::query($query,
                                $name,
                                $firstname,
                                $email,
                                $login,
                                $hash);

        return $user->getExecutionState();
    }

    /**
     * Returns if given email address is already taken by user.
     *
     * @param string $email
     * @return bool
     */
    public static function emailAlreadyTaken(string $email): bool
    {
        $query = "SELECT verifierUsageEmail(?) as resultat";

        return Database::query($query, $email)
            ->get()["resultat"];
    }

    /**
     * Returns if given login is already taken by user.
     *
     * @param string $login
     * @return bool
     */
    public static function loginAlreadyTaken(string $login): bool
    {
        $query = "SELECT verifierUsageLogin(?) as resultat";

        return Database::query($query, $login)
            ->get()["resultat"];
    }

    /**
     * Searches and returns User instance by its id.
     *
     * @param int $id User id
     * @return User|null User object if exists;
     *                   else NULL
     */
    public static function getUserById(int $id): ?User
    {
        $query = "SELECT * FROM utilisateur WHERE id_utilisateur = ?";

        $getUser = Database::query($query, $id);
        $user = $getUser->get();

        if ($user)
        {
            $userInstance = new User();
            $userInstance->setId($id);
            $userInstance->setLastname($user["nom_uti"]);
            $userInstance->setFirstname($user["prenom_uti"]);
            $userInstance->setEmail($user["email_uti"]);
            $userInstance->setLogin($user["login_uti"]);
            $userInstance->setPassword($user["mdp_uti"]);

            return $userInstance;
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
            $modelArray[] = self::getUserById($line["id_utilisateur"]);
        }
        return $modelArray;
    }
}