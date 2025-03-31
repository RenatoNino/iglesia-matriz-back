<?php

namespace App\Http\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Auth\UseCases\RoleUseCases;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function list(Request $request)
    {
        return RoleUseCases::list($request);
    }

    public function change(int $id)
    {
        return RoleUseCases::change($id);
    }
}
