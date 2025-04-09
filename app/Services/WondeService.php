<?php

namespace App\Services;

use App\DTO\Lesson;
use App\DTO\Employee;
use App\DTO\EmployeeClass;
use App\Adapters\WondeAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Contracts\SchoolDataServiceInterface;

readonly class WondeService implements SchoolDataServiceInterface
{
    public function __construct(private WondeAdapter $adapter)
    {
    }

    public function getEmployees($page = 1, $accumulated = []): Collection
    {
        $rawEmployees = $this->paginate('employees', ['has_class' => true], 'wonde-employees');

        return collect($rawEmployees)
            ->map(fn(array $employee) => Employee::fromArray($employee));
    }

    public function getClassesForEmployee($employeeId, $page = 1, $accumulated = []): Collection
    {
        $rawClasses = $this->paginate('classes', ['include' => 'employees,subject'], 'wonde-classes');

        $filtered = array_filter($rawClasses, function ($class) use ($employeeId) {
            return !empty(array_filter($class['employees']['data'], fn($e) => $e['id'] == $employeeId));
        });

        return collect($filtered)
            ->map(fn(array $class) => EmployeeClass::fromArray($class));
    }

    public function getLessonsForEmployee($employeeId, $startAfter = null, $startBefore = null): Collection
    {
        $rawLessons = $this->paginate('lessons', [
            'include' => 'class,employee,employees',
            'lessons_start_after' => $startAfter->format('Y-m-d'),
            'lessons_start_before' => $startBefore->format('Y-m-d'),
        ], 'wonde-lessons');

        $filtered = array_filter($rawLessons, function ($lessons) use ($employeeId) {
                (!empty(array_filter($lessons['emoloyee']['data'], fn($e) => $e['id'] == $employeeId)) ||
                !empty(array_filter($lessons['emoloyees']['data'], fn($e) => $e['id'] == $employeeId)));
        });

        return collect($filtered)
            ->map(fn(array $lesson) => Lesson::fromArray($lesson));
    }

    private function paginate(string $resource, array $params = [], string $cachePrefix = '', int $page = 1, array $accumulated = []): array
    {
        $response = Cache::remember("$cachePrefix-page-$page", 60, function () use ($resource, $params, $page) {
            return $this->adapter->get($resource, array_merge($params, ['page' => $page]))->json();
        });

        $accumulated = array_merge($accumulated, $response['data'] ?? []);

        if ($response['meta']['pagination']['more'] ?? false) {
            return $this->paginate($resource, $params, $cachePrefix, $page + 1, $accumulated);
        }

        return $accumulated;
    }
}
