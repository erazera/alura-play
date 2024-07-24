<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Helper\FlashMessageTrait;
use Alura\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use PDO;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{

    use FlashMessageTrait;
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function handle(ServerRequestInterface $request): Response
    {

        $postData = $request->getParsedBody();
        $email = filter_var($postData['email'], FILTER_VALIDATE_EMAIL);
        $password = $postData['password'];

        if (!$email || !$password) {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }

        $user = $this->repository->loginUser($email, $password);

        if ($user) {
            $_SESSION['logado'] = true;
            $this->repository->updateUserPasswordHash($email, $password);
            return new Response(302, ['Location' => '/']);
        } else {
            $this->addErrorMessage('Usuário ou senha inválidos');
            return new Response(302, ['Location' => '/login']);
        }
    }
}