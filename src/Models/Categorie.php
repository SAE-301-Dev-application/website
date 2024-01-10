<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Categorie extends Model
{
    /** Categorie's id. */
    private int $id;

    /** Categorie's name. */
    private string $name;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("categorie");
    }

    /**
     * @return int Categorie's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id Categorie's id
     * @return int Categorie's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string Categorie's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $title New Categorie's title
     * @return string New Categorie's title
     */
    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    /**
     * Get all categorie.
     * 
     * @return DatabaseQuery Categorie
     */
    public static function getCategorie(): DatabaseQuery
    {
        $getCategoriesQuery
            = "SELECT *
               FROM categorie
               ORDER BY id_categorie ASC;";

        return Database::query($getCategoriesQuery);
    }

    /**
     * Searches and returns Spectacle instance by its id.
     *
     * @param int $id Spectacle id
     * @return Spectacle|null Spectacle object if exists;
     *                       else NULL
     */
    public static function getCategorieById(int $id): ?Categorie
    {
        $query = "SELECT * FROM categorie WHERE id_categorie = ?";

        $getCategorie = Database::query($query, $id);
        $categorie = $getCategorie->get();

        if ($categorie)
        {
            $categorieInstance = new Categorie();

            $categorieInstance
                ->setId($id);

            $categorieInstance
                ->setName($categorie["nom_cat"]);

            return $categorieInstance;
        }

        return null;
    }

    /**
     * Returns Categorie array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array Categorie array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];

        while ($line = $queryObject->get())
        {
            $modelArray[] = self::getCategorieById($line["id_categorie"]);
        }

        return $modelArray;
    }
}