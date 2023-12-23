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
    private string $nom;

    /** User firstname. */
    private string $prenom;

    /** User email address. */
    private string $email;

    /** User login. */
    private string $login;

    public function __construct(string $nom, string $prenom, string $email, string $login)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
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
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return string User firstname
     */
    public function getPrenom(): string
    {
        return $this->prenom;
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
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param string $login
     * @param string $hash
     * @return bool If the account is being created
     */
    public static function create(string $nom,
                                  string $prenom,
                                  string $email,
                                  string $login,
                                  string $hash): bool
    {
        $query = "INSERT INTO utilisateur 
                  (nom_uti, prenom_uti, email_uti, login_uti, mdp_uti) 
                  VALUES (?, ?, ?, ?, ?)";

        $user = Database::query($query,
                                $nom,
                                $prenom,
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