<?php

require 'connection.php';

$id = $_GET['id'];

$repository = new Alura\Mvc\Repository\VideoRepository($pdo);
$repository->remove($id);


if($repository->remove($id) == false){
    header('Location: /?success=0');
} else {
    header('Location: /?success=1');
}