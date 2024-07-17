<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video 
{

    public int $id;

    public function __construct(
        public string $url,
        public readonly string $title,

    ) {
        $this->setUrl($url);
    }

    private function setUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('URL inválida');
        }

        $this->url = $url;
    }

    public function setId(int $id): void
    {
        if ($id === null || $id <= 0) {
            throw new \InvalidArgumentException('ID inválido');
        }

        $this->id = $id;
    }
}