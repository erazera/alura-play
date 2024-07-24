<?php

namespace Alura\Mvc\Controller;

use Psr\Http\Server\RequestHandlerInterface;

abstract class HtmlController implements RequestHandlerInterface
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    public function renderTemplate(string $templateName, array $data = [])
    {
    
        extract($data);

        ob_start();
        require self::TEMPLATE_PATH   . $templateName . '.php';
        return ob_get_clean();

    }
}