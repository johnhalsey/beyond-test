<?php

namespace App\DTO;

class EmployeeClass
{
    public function __construct(
        public string $id,
        public string $name,
        public string $description,
        public string $year_group,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['year_group'] ?? '',
        );
    }
}
