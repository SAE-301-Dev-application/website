<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Scene extends Model
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
        parent::__construct("scene");

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
                                  float $longitude,
                                  float $latitude): bool
    {
        $query = "CALL ajouterScene(?, ?, ?, ?, ?)";

        $user = Database::query($query,
                                $nom,
                                $taille,
                                $maxSpectateurs,
                                $latitude,
                                $longitude);

        return $user->getExecutionState();
    }
}