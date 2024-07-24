<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/Repository/connection.php'; // Assuming this file returns a PDO instance in $pdo

use Alura\Mvc\Entity\User;
use Alura\Mvc\Repository\UserRepository;

$email = 'admin@admin1.com';
$password = 'password';

$user = new User($email, $password);

$userRepository = new UserRepository($pdo);

$userRepository->add($user);
