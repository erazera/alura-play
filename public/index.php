<?php

declare(strict_types=1);

use Alura\Mvc\Controller\Controller;
use Alura\Mvc\Controller\DeleteVideoController;
use Alura\Mvc\Controller\EditVideoController;
use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Controller\NewVideoController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Controller\SendVideoController;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Repository\UserRepository;

require_once __DIR__ . '/../src/Repository/connection.php';
require_once __DIR__ . '/../vendor/autoload.php';

session_set_cookie_params([
    'lifetime' => 0, // or specify a time in seconds
    'path' => '/',
    'secure' => true, // set to true if your site is served over HTTPS
    'httponly' => true, // true makes it inaccessible to JavaScript
]);
session_start();

$routes = require_once __DIR__ . '/../config/routes.php';
$diConteiner = require_once __DIR__ . '/../config/diConteiner.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}

$key = "$httpMethod|$path";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$path"];

    $controller = $container->get($controllerClass);
} else {
    $controller = new Error404Controller();
}

if ($path === '/login') {
    $repository = new UserRepository($pdo);
} else {
    $repository = new VideoRepository($pdo);
}


$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory,  // StreamFactory
);

$request = $creator->fromGlobals();

/** @var \Psr\Http\Server\RequestHandlerInterface $controller */
$response = $controller->handle($request);

http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();