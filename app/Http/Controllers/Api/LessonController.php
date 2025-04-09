<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LessonController extends Controller
{
    public function index(Request $request, string $employeeId): AnonymousResourceCollection
    {
        $startAfter = $request->has('startAfter') ? Carbon::parse($request->get('startAfter')) : Carbon::now();

        $lessons = $this->schoolDataServiceInterface->getLessonsForEmployee($employeeId, $startAfter);

        return LessonResource::collection($lessons);
    }
}
