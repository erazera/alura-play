<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController implements Controller
{

    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }
    public function processaRequisicao(): void 
    {
        $videos = $this->repository->all();
        require __DIR__ . '/../../views/video-list.php';
        }
}