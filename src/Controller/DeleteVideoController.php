<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use \Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Entity\Video;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteVideoController implements RequestHandlerInterface
{

    use FlashMessageTrait;
    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id == null) {
            $this->addErrorMessage('Id inválido');
            header('Location: /');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
       
        $success = $this->repository->remove($id);

        if($success == false){
            $this->addErrorMessage('Erro ao remover vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}