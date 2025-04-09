<?php

namespace App\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface SchoolDataServiceInterface
{
    public function getEmployees(): Collection;

    public function getClassesForEmployee($employeeId): Collection;

    public function getLessonsForEmployee($employeeId, Carbon $startAfter = null): Collection;
}
