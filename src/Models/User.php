<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;

class User
{
    /** User id. */
    private int $id;

    /** User lastname */
    private string $name;

    /** User firstname. */
    private string $firstname;

    /** User email address. */
    private string $email;

    /** User login. */
    private string $login;

    public function __construct(string $name, string $firstname, string $email, string $login)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->email = $email;
        $this->login = $login;
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
    public function getName(): string
    {
        return $this->name;
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
}