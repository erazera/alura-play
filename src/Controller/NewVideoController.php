<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Entity\Video;
use PDO;

class NewVideoController implements Controller
{

    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
          header('Location: /?sucesso=0');
          exit();
        }
        $title = filter_input(INPUT_POST, 'titulo');
        if ($title === false) {
          header('Location: /?sucesso=0');
          exit();
        }
        
        $success = $this->repository->add(new Video($url, $title));
        if($success == false){
            header('Location: /?success=0');
        } else {
            header('Location: /?success=1');
        }

        
        
    }
}