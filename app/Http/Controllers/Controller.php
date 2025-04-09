<?php

namespace App\Http\Controllers;

use App\Contracts\SchoolDataServiceInterface;

abstract class Controller
{
    public function __construct(protected readonly SchoolDataServiceInterface $schoolDataServiceInterface)
    {
    }
}
