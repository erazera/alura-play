<?php

declare(strict_types=1);

use Alura\Mvc\Controller\DeleteVideoController;
use Alura\Mvc\Controller\EditVideoController;
use Alura\Mvc\Controller\NewVideoController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\SendVideoController;
use Alura\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../src/Repository/connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

$videoRepository = new VideoRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$path";
if(!array_key_exists($key, $routes)){
    http_response_code(404);
    exit();
}
$controllerClass = $routes["$httpMethod|$path"];

$controller = new $controllerClass($videoRepository);
$controller->processaRequisicao();