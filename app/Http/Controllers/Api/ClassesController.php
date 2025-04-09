<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClassResource;
use App\Contracts\SchoolDataServiceInterface;

class ClassesController extends Controller
{
    public function index(string $employeeId)
    {
        try{
            $classes = $this->schoolDataServiceInterface->getClassesForEmployee($employeeId);
        } catch(\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], $e->getCode());
        }

        return ClassResource::collection($classes);
    }
}
