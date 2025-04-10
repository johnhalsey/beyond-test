<?php

namespace App\Services;

use Carbon\Carbon;
use App\DTO\Lesson;
use App\DTO\Employee;
use App\Adapters\WondeAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Contracts\SchoolDataServiceInterface;

readonly class WondeService implements SchoolDataServiceInterface
{
    private const CACHE_TTL = 60;

    public function __construct(private WondeAdapter $adapter)
    {
    }

    public function getEmployees(int $page = 1, array $accumulated = []): Collection
    {
        $rawEmployees = $this->paginate('employees', ['has_class' => true], 'wonde-employees');

        return collect($rawEmployees)
            ->map(fn(array $employee) => Employee::fromArray($employee));
    }

    public function getClass(string $classId): Collection
    {
       return $this->adapter->get("classes/$classId", ['include' => 'students'])->collect();
    }

    public function getLessonsForEmployee(string $employeeId, Carbon $startAfter): Collection
    {
        $startDateFormatted = $startAfter->format('Y-m-d');
        $endDateFormatted = (clone $startAfter)->addDay()->format('Y-m-d');

        $rawLessons = $this->paginate('lessons', [
            'include'              => 'class,employee,employees',
            'lessons_start_after'  => $startDateFormatted,
            'lessons_start_before' => $endDateFormatted,
        ], 'wonde-lessons-' . $startDateFormatted);

        $filtered = array_filter($rawLessons, function ($lesson) use ($employeeId) {
            $primaryEmployee = $lesson['employee']['data']['id'] ?? null;
            $otherEmployees = $lesson['employees']['data'] ?? [];

            $isPrimary = $primaryEmployee === $employeeId;
            $isSecondary = !empty(array_filter($otherEmployees, fn($e) => $e['id'] === $employeeId));

            return $isPrimary || $isSecondary;
        });

        return collect($filtered)
            ->map(fn(array $lesson) => Lesson::fromArray($lesson));
    }

    private function paginate(string $resource, array $params = [], string $cachePrefix = '', int $page = 1, array $accumulated = []): array
    {
        $response = Cache::remember("$cachePrefix-page-$page", self::CACHE_TTL, function () use ($resource, $params, $page) {
            return $this->adapter->get($resource, array_merge($params, ['page' => $page]))->json();
        });

        $accumulated = array_merge($accumulated, $response['data'] ?? []);

        if ($response['meta']['pagination']['more'] ?? false) {
            return $this->paginate($resource, $params, $cachePrefix, $page + 1, $accumulated);
        }

        return $accumulated;
    }
}
