<?php

namespace App\Users\Application\DTO;

class RegisterUserInputDto
{

    
    private string $email;
    private string $password;
    private string $firstname;
    private string $lastname;

    // Constructor to initialize the properties
    public function __construct(string $email = '', string $password = '', string $firstname = '', string $lastname = '')
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    public function getFirstname(): string { return $this->firstname; }
    public function setFirstname(string $firstname): void { $this->firstname = $firstname; }

    public function getLastname(): string { return $this->lastname; }
    public function setLastname(string $lastname): void { $this->lastname = $lastname; }
}