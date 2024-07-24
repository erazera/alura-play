<?php

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\User;

class UserRepository
{
    public function __construct(private \PDO $pdo)
    {

    }

    public function add(User $user): bool
    {
        $sql = 'INSERT INTO users (email, password) VALUES (?, ?)';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $user->getEmail());
        $statement->bindValue(2, $user->getHashedPassword());
        return $statement->execute();

    }

    public function hydrate(array $userData): User
    {
        return new User($userData['email'], $userData['password']);
    }

    public function getUserByEmail($email)
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function loginUser(string $email, string $password): bool {
        $user = $this->getUserByEmail($email); // Method to fetch user details from the database

        if ($user && password_verify($password,  $user['password'] ?? '')) {
            return true; 
        }
        return false; 
    }

    public function updateUserPasswordHash(string $email, string $password): void {
        $user = $this->getUserByEmail($email); // Method to fetch user details from the database

        if (password_needs_rehash($user['password'], PASSWORD_ARGON2ID)) {
            // Rehash the password with the new algorithm/options
            $newHash = password_hash($password, PASSWORD_ARGON2ID);
            // Update the user's password hash in the database
            $this->updateUserPasswordHash($user['email'], $newHash);
            $sql = 'UPDATE users SET password = ? WHERE email = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $newHash);
            $stmt->bindValue(2, $email);
            $stmt->execute();
        }
      
    }
}