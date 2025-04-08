<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\SchoolDataServiceInterface;

class HomeController extends Controller
{
    public function __construct(private SchoolDataServiceInterface $schoolDataServiceInterface)
    {

    }

    public function index()
    {
        //  get employees
    }
}
