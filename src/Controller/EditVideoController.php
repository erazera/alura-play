<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\VideoRepository;
use Alura\Mvc\Entity\Video;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EditVideoController implements RequestHandlerInterface
{

    use FlashMessageTrait;

    public function __construct( private VideoRepository $repository)
    {
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

        $requestBody = $request->getParsedBody();

        $url = filter_var($requestBody['url'],  FILTER_VALIDATE_URL);
        if ($url === false) {
            $this->addErrorMessage('Url inválida');
            return new Response(302, [
                'Location' => '/enviar-video'
            ]);
        }

        $title = filter_var($requestBody['titulo']);
        if ($title === false) {
            $this->addErrorMessage('Título Inválido');
            return new Response(302, [
                'Location' => '/enviar-video'
            ]);
        }

        $video = new Video($url, $title);
        $video->setId($id); 

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->repository->update($video);

        if ($success === false) {
            $this->addErrorMessage('Erro ao atualizar o vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(302, [
            'Location' => '/'
        ]);
    }
}