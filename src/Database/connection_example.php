<?php

/*
 * connection.php
 * MVCLite by belicfr
 *
 * Please edit the connection information
 * to use your databse properly.
 */

use MvcLite\Database\Engine\Database;
use MvcLite\Database\Engine\Exceptions\FailedConnectionToDatabaseException;

const DATABASE_CREDENTIALS = [

    "dbms"          =>  "mysql",

    "host"          =>  "localhost",
    "port"          =>  "8889",
    "name"          =>  "Festiplan",
    "user"          =>  "root",
    "password"      =>  "root"

];


$db = (new Database(DATABASE_CREDENTIALS))->attemptConnection();

if (!$db)
{
    $error = new FailedConnectionToDatabaseException();
    $error->render();
}