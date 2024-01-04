<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;

class Scene
{
    /** User id. */
    private int $id;

    private string $nom;

    private int $taille;

    private int $maxSpectateurs;

    private string $coordonnees;

    public function __construct(int $id,
                                string $nom,
                                int $taille,
                                int $maxSpectateurs,
                                string $coordonnees)
    {
        $this->nom = $nom;
        $this->taille = $taille;
        $this->maxSpectateurs = $maxSpectateurs;
        $this->coordonnees = $coordonnees;
    }

    /**
     * Attempt to create a scene with given information.
     *
     * @param string $nom
     * @param int $taille
     * @param int $maxSpectateurs
     * @param string $coordonnees
     * @return bool If the scene is being created
     */
    public static function create(string $nom,
                                  int $taille,
                                  int $maxSpectateurs,
                                  string $coordonnees): bool
    {
        $query = "INSERT INTO scene 
                  (nom_sc, taille_sc, nb_max_spectateurs, coordonnees_sc) 
                  VALUES (?, ?, ?, ?)";

        $user = Database::query($query,
                                $nom,
                                $taille,
                                $maxSpectateurs,
                                $coordonnees);

        return $user->getExecutionState();
    }
}