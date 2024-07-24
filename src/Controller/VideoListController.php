<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoListController implements RequestHandlerInterface
{

    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates,
    ) {
    }
    public function handle(ServerRequestInterface $request): Response 
    {
        if (!array_key_exists('logado', $_SESSION) || !$_SESSION['logado']) {
            return new Response(302, ['Location' => '/login']);
        }
        $videoList = $this->videoRepository->all();
        return new Response(200, body: $this->templates->render(
            'video-list',
            ['videoList' => $videoList]
        ));

    }
}