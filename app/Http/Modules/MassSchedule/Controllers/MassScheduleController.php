<?php

namespace App\Http\Modules\MassSchedule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MassSchedule\UseCases\MassScheduleUseCases;
use Illuminate\Http\Request;

class MassScheduleController extends Controller
{
    public function list()
    {
        return MassScheduleUseCases::list();
    }

    public function create(Request $request)
    {
        return MassScheduleUseCases::create($request);
    }

    public function update(Request $request, $id)
    {
        return MassScheduleUseCases::update($request, $id);
    }

    public function delete($id)
    {
        return MassScheduleUseCases::delete($id);
    }
}
