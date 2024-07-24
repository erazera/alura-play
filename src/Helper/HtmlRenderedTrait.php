<?php

namespace Alura\Mvc\Helper;

trait HtmlRenderedTrait
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    private function renderTemplate(string $templateName, array $data = [])
    {
    
        extract($data);

        ob_start();
        require self::TEMPLATE_PATH   . $templateName . '.php';
        return ob_get_clean();

    }
}