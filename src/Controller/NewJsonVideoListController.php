<?php


namespace Alura\Mvc\Controller;
use Alura\MVc\Entity\Video;
use Alura\Mvc\Repository\VideoRepository;

class NewJsonVideoListController implements Controller
{

    public function __construct(private VideoRepository $repository)
    {
    }
    public function processaRequisicao(): void
    {

        $request = file_get_contents('php://input');
        $videoData = json_decode($request, true);
        $video = new Video($videoData['url'], $videoData['title']);
        $this->repository->add($video);

        http_response_code(201);
    }
}