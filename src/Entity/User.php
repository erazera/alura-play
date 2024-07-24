<?php
namespace Alura\Mvc\Entity;

class User
{
    private string $email;
    private string $hashedPassword; // Assuming you have a property for the hashed password

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->setPassword($password); // Hash password upon user creation
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->hashedPassword);
    }

    // Any other methods you need...
}