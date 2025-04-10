<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LessonController extends Controller
{
    public function index(Request $request, string $employeeId): AnonymousResourceCollection|JsonResponse
    {
        $startAfter = $request->has('startAfter') ? Carbon::parse($request->get('startAfter')) : Carbon::now();

        try{
            $lessons = $this->schoolDataServiceInterface->getLessonsForEmployee($employeeId, $startAfter);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        return LessonResource::collection($lessons);
    }
}
