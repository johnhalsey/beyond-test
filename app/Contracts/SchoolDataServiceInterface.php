<?php

namespace App\Contracts;

use Carbon\Carbon;
use App\DTO\EmployeeClass;
use Illuminate\Support\Collection;

interface SchoolDataServiceInterface
{
    public function getEmployees(): Collection;

    public function getClass(string $classId): Collection;

    public function getLessonsForEmployee($employeeId, Carbon $startAfter = null): Collection;
}
