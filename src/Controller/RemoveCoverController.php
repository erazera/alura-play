<?php 

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveCoverController implements RequestHandlerInterface
{

    use FlashMessageTrait;
    private VideoRepository $repository;
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }
    public function handle(ServerRequestInterface $request): Response
    {
        $queryParams = $request->getQueryParams();
        $id = filter_input($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id == null) {
            $this->addErrorMessage('Id inválido');
            return new Response(200, ['Location' => '/']);

        }

        $success = $this->repository->removeCover($id);

        if($success == false){
            $this->addErrorMessage('Erro ao remover capa');
            return new Response(200, ['Location' => '/']);
        } 
        return new Response(200, ['Location' => '/']);        
    }
}