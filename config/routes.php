<?php

declare(strict_types=1);

return [
    'GET|/' => \Alura\Mvc\Controller\VideoListController::class,
    'GET|/enviar-video' => \Alura\Mvc\Controller\SendVideoController::class,
    'POST|/enviar-video' => \Alura\Mvc\Controller\NewVideoController::class,
    'GET|/editar-video' => \Alura\Mvc\Controller\SendVideoController::class,
    'POST|/editar-video' => \Alura\Mvc\Controller\EditVideoController::class,
    'GET|/remover-video' => \Alura\Mvc\Controller\DeleteVideoController::class,
    'GET|/login' => \Alura\Mvc\Controller\LoginFormController::class,
    'POST|/login' => \Alura\Mvc\Controller\LoginController::class,
    'GET|/logout' => \Alura\Mvc\Controller\LogoutController::class,
    'GET|/remover-capa' => \Alura\Mvc\Controller\RemoveCoverController::class,
    'GET|/videos-json' => \Alura\Mvc\Controller\JsonVideoListController::class,
    'POST|/videos' => \Alura\Mvc\Controller\NewJsonVideoListController::class,



];