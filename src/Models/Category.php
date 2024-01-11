<?php

namespace MvcLite\Models;

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\DatabaseQuery;
use MvcLite\Engine\DevelopmentUtilities\Debug;
use MvcLite\Engine\InternalResources\Storage;
use MvcLite\Engine\Security\Password;
use MvcLite\Models\Engine\Model;

class Category extends Model
{
    /** Category's id. */
    private int $id;

    /** Category's name. */
    private string $name;

    public function __construct()
    {
        parent::__construct();

        $this->setTableName("categorie");
    }

    /**
     * @return int Category's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id Category's id
     * @return int Category's id
     */
    private function setId(int $id): int
    {
        return $this->id = $id;
    }

    /**
     * @return string Category's name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name New Category's name
     * @return string New Category's name
     */
    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    /**
     * Get all categories.
     * 
     * @return DatabaseQuery Category
     */
    public static function getAllCategories(): DatabaseQuery
    {
        $getCategoriesQuery
            = "SELECT *
               FROM categorie
               ORDER BY id_categorie ASC;";

        return Database::query($getCategoriesQuery);
    }

    /**
     * Searches and returns category instance by its data.
     *
     * @param array $categoryData Category data
     * @return Category Category object
     */
    public static function getCategoryInstance(array $categoryData): Category
    {
        $categoryInstance = new Category();

        $categoryInstance->setId($categoryData["id_categorie"]);

        $categoryInstance->setName($categoryData["nom_cat"]);

        return $categoryInstance;
    }

    /**
     * Searches and returns Spectacle instance by its id.
     *
     * @param int $id Spectacle id
     * @return Spectacle|null Spectacle object if exists;
     *                       else NULL
     */
    public static function getCategoryById(int $id): ?Category
    {
        $query = "SELECT * FROM categorie WHERE id_categorie = ?";

        $getCategory = Database::query($query, $id);
        $category = $getCategory->get();

        if ($category)
        {
            $categoryInstance = new Category();

            $categoryInstance
                ->setId($id);

            $categoryInstance
                ->setName($category["nom_cat"]);

            return $categoryInstance;
        }

        return null;
    }

    /**
     * Returns Category array by using DatabaseQuery object.
     *
     * @param DatabaseQuery $queryObject
     * @return array Category array
     */
    public static function queryToArray(DatabaseQuery $queryObject): array
    {
        $modelArray = [];

        foreach($queryObject->getAll() as $category)
        {
            $modelArray[] = self::getCategoryInstance($category);
        }

        return $modelArray;
    }
}