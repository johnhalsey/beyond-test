<?php

namespace App\Contracts;

interface SchoolDataServiceInterface
{
    public function getEmployees(): array;

    public function getClassesForEmployee($employeeId);

    public function getClassLessonsForEmployee($classId, $employeeId, $startDate = null);
}
