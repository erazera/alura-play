<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendVideoController implements RequestHandlerInterface
{

    private VideoRepository $videoRepository;

    public function __construct(
        private VideoRepository $repository,
        private Engine $templates
    ) {
    }


    public function handle(ServerRequestInterface $request): Response
    {

        if (!array_key_exists('logado', $_SESSION) || !$_SESSION['logado']) {
            return new Response(302, ['Location' => '/login']);
        }
        
        $queryParams = $request->getQueryParams();
        $id = isset($queryParams['id']) ? filter_var($queryParams['id'], FILTER_VALIDATE_INT) : false;
    
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->repository->find($id);
        }
    
        return new Response(200, body: $this->templates->render('video-form', [
            'video' => $video,
        ]));
    
    }
}