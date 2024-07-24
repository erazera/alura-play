<?php

use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([
    \PDO::class => function (): PDO {
        return new PDO('mysql:host=mysql;dbname=aluraplay', 'user', 'password', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    },

    \League\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../views';
        return new League\Plates\Engine($templatePath);
    }
]);


/** @var \Psr\Container\ContainerInterface $container */
$container = $builder->build();

return $container;