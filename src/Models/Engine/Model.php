<?php

namespace MvcLite\Models\Engine;

use MvcLite\Database\Engine\Database;

class Model
{
    /** Model table name. */
    private string $tableName;

    public function __construct()
    {
        // Empty constructor.
    }

    /**
     * @return string Model table name
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName New model table name
     * @return string New model table name
     */
    public function setTableName(string $tableName): string
    {
        return $this->tableName = $tableName;
    }

    /**
     * @param string $column Column name
     * @param string $value Value searched
     * @return bool If value exists in given table column
     */
    public function isColumnValueExisting(string $column, string $value): bool
    {
        $query = "SELECT COUNT(*) as count FROM "
               . $this->tableName
               . " WHERE $column = ?";

        $searching = Database::query($query, $value);
        $result = $searching->get();

        return $result["count"];
    }
}