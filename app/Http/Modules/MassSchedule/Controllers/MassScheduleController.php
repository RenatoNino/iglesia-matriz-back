<?php

namespace App\Http\Modules\MassSchedule\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\MassSchedule\UseCases\MassScheduleUseCases;

class MassScheduleController extends Controller
{
    public function list()
    {
        return MassScheduleUseCases::list();
    }

    public function create()
    {
        return MassScheduleUseCases::create(request());
    }

    public function update($id)
    {
        return MassScheduleUseCases::update(request(), $id);
    }

    public function delete($id)
    {
        return MassScheduleUseCases::delete($id);
    }
}
