<?php

namespace App\Services;

use Carbon\Carbon;
use App\DTO\Lesson;
use App\DTO\Employee;
use App\DTO\EmployeeClass;
use App\Adapters\WondeAdapter;
use Illuminate\Support\Collection;
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

    public function getClass(string $classId): EmployeeClass
    {
       $response = $this->adapter->get("classes/$classId", ['include' => 'students'])->json();

        return new EmployeeClass($response);
    }

    public function getLessonsForEmployee($employeeId, Carbon $startAfter = null): Collection
    {
        $startDateFormatted = $startAfter->format('Y-m-d');
        $endDateFormatted = $startAfter->addDays(7)->format('Y-m-d');

        $rawLessons = $this->paginate('lessons', [
            'include'              => 'class,employee,employees',
            'lessons_start_after'  => $startDateFormatted,
            'lessons_start_before' => $endDateFormatted,
        ], 'wonde-lessons-' . $startDateFormatted);

        $filtered = array_filter($rawLessons, function ($lessons) use ($employeeId) {
            return (isset($lessons['employee']['data']) && $lessons['employee']['data']['id'] == $employeeId) ||
                    (isset($lessons['employees']['data']) && !empty(array_filter($lessons['employees']['data'], fn($e) => $e['id'] == $employeeId)));
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
