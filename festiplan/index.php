<?php
const PREFIX_TO_RELATIVE_PATH = "/festiplan";
require $_SERVER[ 'DOCUMENT_ROOT' ] . PREFIX_TO_RELATIVE_PATH . '/lib/vendor/autoload.php';

use application\DefaultComponentFactory;
use yasmf\DataSource;
use yasmf\Router;

$dataSource = new DataSource(
    $host       = "localhost",
    $port       = "8889",
    $db         = "IUT_BANK",
    $user       = "root",
    $pass       = "",
    $charset    = "utf8mb4"
);

$router = new Router(new DefaultComponentFactory(), $dataSource) ;
$router->route(PREFIX_TO_RELATIVE_PATH, $dataSource);
