<?php

namespace App\Http\Modules\MassType\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MassType\UseCases\MassTypeUseCases;
use Illuminate\Http\Request;

class MassTypeController extends Controller
{
    public function list(Request $request)
    {
        return MassTypeUseCases::list($request);
    }

    public function create(Request $request)
    {
        return MassTypeUseCases::create($request);
    }

    public function update(int $id, Request $request)
    {
        return MassTypeUseCases::update($id, $request);
    }

    public function delete(int $id)
    {
        return MassTypeUseCases::delete($id);
    }
}
