<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;

class Festival
{
    //------ First part - The festival's global parameters------

    /** Festival's id. */
    private int $id;  // Auto-incrément dans la BDD

    /** Festival's name */
    private string $nom;

    /** Festival's description. */
    private string $description;

    /** Festival's start date. */
    private string $dateDebut;

    /** Festival's end date. */
    private int $dateFin;

    /** Festival's themes */
    private string $categories;

    /** Festival's illustration */
    private string $image;

    //------ Second part - The scenes' choice------

    /** Festival's scenes. */
    private string $scenes;  // Objet Scene

    //------ Third part - The festival's team------

    /** Festival's owner */
    private string $responsable;

    /** Festival's team */
    private string $equipe;    

    //------ Fourth part - The shows' choice ------

    /** Festival's shows. */
    private string $spectacles; // Objet Spectacle

    //------ Last part - The festival's planning ------

    /** Festival's planning. */
    private string $Grij;

    public function __construct(string $nom, string $description, string $dateDebut, string $dateFin, string $categories, string $image)
    {

        if (isset($nom) && str_len($nom) < 50 && !empty($nom)) {

            $this->nom = $nom;
        } else {
            //throw()
        }
        

        $this->description = $description;

        $this->dateDebut = $dateDebut;

        $this->dateFin = $dateFin;

        $this->categories = $categories;

        $this->image = $image;
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
        $query = "SELECT COUNT(*) as count FROM utilisateur WHERE email_uti = ?";

        return Database::query($query, $email)
            ->get()["count"];
    }

    /**
     * Returns if given login is already taken by user.
     *
     * @param string $login
     * @return bool
     */
    public static function taille(string $login): bool
    {
        $query = "SELECT COUNT(*) as count FROM utilisateur WHERE login_uti = ?";

        return Database::query($query, $login)
            ->get()["count"];
    }
}