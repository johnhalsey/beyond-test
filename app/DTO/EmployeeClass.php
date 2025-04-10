<?php

namespace App\DTO;

class EmployeeClass
{
    public function __construct(
        public string $id,
        public string $name,
        public array $students,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'] ?? '',
            isset($data['students']) ? Student::manyFromArray($data['students']['data']) : [],
        );
    }
}
