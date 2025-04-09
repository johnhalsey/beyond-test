<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Contracts\SchoolDataServiceInterface;

class HomeController extends Controller
{
    public function __construct(private readonly SchoolDataServiceInterface $schoolDataServiceInterface)
    {
    }

    public function index()
    {
        try{
            $emplyees = $this->schoolDataServiceInterface->getEmployees();
        } catch (\Exception){
            return redirect()->route('error');
        }

        return Inertia::render('Home', ['employees' => $emplyees]);
    }
}
