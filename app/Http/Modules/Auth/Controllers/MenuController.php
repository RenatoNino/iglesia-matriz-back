<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Auth\UseCases\MenuUseCases;

class MenuController extends Controller
{
    public function get()
    {
        return MenuUseCases::get();
    }
}
