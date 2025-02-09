<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/core/Router.php';

use App\Core\Router;

$router = new Router();
$router->handleRequest();