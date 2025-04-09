<?php

namespace App\DTO;

class Employee
{
    public function __construct(
        public string $id,
        public string $title,
        public string $forename,
        public string $surname,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['title'] ?? '',
            $data['forename'] ?? '',
            $data['surname'] ?? '',
        );
    }
}
