<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class SendVideoController implements Controller
{

    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $video = null;
        if($id !== false && $id !== null){
            $video = $this->repository->find($id);
        }

        require __DIR__ . '/../../views/video-form.php';
       
    }
}