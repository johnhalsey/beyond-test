<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;

class ClassController extends Controller
{
    public function show(Request $request, string $classId): ClassResource|JsonResponse
    {
        try{
            $class = $this->schoolDataServiceInterface->getClass($classId);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], $ex->getCode());
        }

        return new ClassResource((object)$class['data']);
    }
}
