<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Contracts\SchoolDataServiceInterface;

class LessonController extends Controller
{
    public function index(Request $request, string $emplyeeId, string $classId)
    {
        $startAfter = $request->has('startAfter') ? $request->get('startAfter') : Carbon::now();
        $startAfter = Carbon::parse($startAfter)->format('Y-m-d');

        $lessons = $this->schoolDataServiceInterface->getClassLessonsForEmployee($emplyeeId, $classId, $startAfter);
    }
}
