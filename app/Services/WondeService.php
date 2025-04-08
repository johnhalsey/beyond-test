<?php

namespace App\Services;

use App\Adapters\WondeAdapter;
use Illuminate\Support\Facades\Cache;
use App\Contracts\SchoolDataServiceInterface;

readonly class WondeService implements SchoolDataServiceInterface
{
    public function __construct(private WondeAdapter $adapter)
    {
    }

    public function getEmployees($page = 1, $accumulated = []): array
    {
        $response = Cache::remember('wonde-employees-page-' . $page, 60, function () use ($page){
            return $this->adapter->get('employees', ['has_class' => true, 'page' => $page])->json();
        });

        $accumulated = array_merge($accumulated, $response['data'] ?? []);

        if ($response['meta']['pagination']['more']) {
            return $this->getEmployees($page + 1, $accumulated);
        }

        return $accumulated;
    }

    public function getClassesForEmployee($employeeId)
    {

    }

    public function getClassLessonsForEmployee($classId, $employeeId, $startDate = null)
    {

    }
}
