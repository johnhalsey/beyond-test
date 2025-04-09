<?php

namespace App\DTO;

class Student
{
    public function __construct(
        public string $id,
        public string $forename,
        public string $surname,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['forename'] ?? '',
            $data['surname'] ?? '',
        );
    }

    public static function manyFromArray(array $arrays): array
    {
        $students = [];

        foreach ($arrays as $array) {
            $students[] = self::fromArray($array);
        }

        return $students;
    }


}
