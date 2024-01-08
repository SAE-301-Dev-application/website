<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Engine\Session\Session;
use MvcLite\Models\Engine\Model;

class User extends Model
{
    public const FIRSTNAME_MAX_LENGTH = 25;

    public const FIRSTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,25}$/u";

    public const LASTNAME_MAX_LENGTH = 50;

    public const LASTNAME_REGEX = "/^[a-zA-ZÀ-ÿ\s\-']{1,50}$/u";

    public const LOGIN_MIN_LENGTH = 3;

    public const LOGIN_MAX_LENGTH = 25;

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

    public function __construct(array $databaseUserRow)
    {
        parent::__construct();

        $this->setTableName("utilisateur");

        $this->id = $databaseUserRow["id_utilisateur"];
        $this->lastname = $databaseUserRow["nom_uti"];
        $this->firstname = $databaseUserRow["prenom_uti"];
        $this->email = $databaseUserRow["email_uti"];
        $this->login = $databaseUserRow["login_uti"];
    }

    /**
     * @return int User id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string User lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string User firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string User email address
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string User login
     */
    public function getLogin(): string
    {
        return $this->login;
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

        return $user
            ? new User($user)
            : null;
    }
}