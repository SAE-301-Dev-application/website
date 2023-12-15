<?php

namespace services;

use PDO;
use PDOStatement;

/**
 *
 */
class ExampleService
{
    /**
     * @param PDO $pdo
     * @return int
     */
    public function getExample(PDO $pdo): int
    {
        return 1;
    }
}