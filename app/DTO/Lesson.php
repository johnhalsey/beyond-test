<?php

namespace App\DTO;

class Lesson
{
    public function __construct(
        public string $id,
        public string $startAt,
        public string $endAt,
        public object $class,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['start_at']['date'] ?? '',
            $data['end_at']['date'] ?? '',
            isset($data['class']['data']) ? EmployeeClass::fromArray($data['class']['data']) : '',
        );
    }

}
