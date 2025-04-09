<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface SchoolDataServiceInterface
{
    public function getEmployees(): Collection;

    public function getClassesForEmployee($employeeId): Collection;

    public function getLessonsForEmployee($employeeId, $startAfter = null, $startBefore = null): Collection;
}
