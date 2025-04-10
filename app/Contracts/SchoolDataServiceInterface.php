<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface SchoolDataServiceInterface
{
    public function getEmployees(): Collection;

    public function getClass(string $classId): Collection;

    public function getLessonsForEmployee(string $employeeId, Carbon $startAfter): Collection;
}
