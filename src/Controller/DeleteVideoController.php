<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Entity\Video;
use PDO;

class DeleteVideoController implements Controller
{

    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id == null) {
            header('Location: /?sucesso=0');
            exit();
        }
       
        $success = $this->repository->remove($id);

        if($success == false){
            header('Location: /?success=0');
        } else {
            header('Location: /?success=1');
        }
    }
}