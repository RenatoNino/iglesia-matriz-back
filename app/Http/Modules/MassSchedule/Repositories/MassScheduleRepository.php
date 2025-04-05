<?php

namespace App\Http\Modules\MassSchedule\Repositories;

use App\Models\MassSchedule;
use Exception;
use Illuminate\Http\Request;

class MassScheduleRepository
{
    public static function list()
    {
        return MassSchedule::orderBy('day_of_week')
            ->orderBy('start_time')
            ->get([
                'id',
                'day_of_week',
                'start_time',
            ]);
    }

    public static function create(Request $request)
    {
        $schedule = MassSchedule::create([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
        ]);

        return $schedule;
    }

    public static function update(Request $request, $id)
    {
        $schedule = MassSchedule::find($id);

        if (!$schedule) {
            throw new Exception('Horario no encontrado.');
        }

        $schedule->update([
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
        ]);

        return $schedule;
    }

    public static function delete($id)
    {
        $schedule = MassSchedule::find($id);

        if (!$schedule) {
            throw new Exception('Horario no encontrado.');
        }

        $schedule->delete();

        return $schedule;
    }
}
