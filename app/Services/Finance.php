<?php

namespace App\Services;

use App\Models\Finance\Group;

class Finance
{
    private $group;

    public function __construct()
    {
        //
    }

    public function group()
    {
        return $this->group;
    }
}