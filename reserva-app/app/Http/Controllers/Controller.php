<?php

namespace App\Http\Controllers;

use App\Traits\PaginateTrait;
use App\Traits\RequestFiltersTrait;

abstract class Controller
{
    use RequestFiltersTrait, PaginateTrait;

    public function __construct() {}
}
