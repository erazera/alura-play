<?php

require 'connection.php';

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

$repository = new Alura\Mvc\Repository\VideoRepository($pdo);
$repository->add(new Alura\Mvc\Entity\Video($url, $title));


if ($repository->add(new Alura\Mvc\Entity\Video($url, $title)) == false){
    header('Location: /?success=0');
} else {
    header('Location: /?success=1');
}
