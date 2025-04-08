<?php

namespace App\Contracts;

interface SchoolDataServiceInterface
{
    public function getEmployee();

    public function getClassesForEmployee($employeeId);

    public function getClassLessonsForEmployee($classId, $employeeId, $startDate = null);
}
