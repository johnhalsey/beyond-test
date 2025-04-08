<?php

namespace App\Services;

use App\Adapters\WondeAdapter;
use App\Contracts\SchoolDataServiceInterface;

class WondeService implements SchoolDataServiceInterface
{
    public function __construct(private readonly WondeAdapter $wondeAdapter)
    {
    }
}
