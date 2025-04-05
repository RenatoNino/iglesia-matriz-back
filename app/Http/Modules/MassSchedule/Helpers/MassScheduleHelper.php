<?php

namespace App\Http\Modules\MassSchedule\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MassSchedule;

class MassScheduleHelper
{
    public static function validateCreateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $existingSchedule = MassSchedule::where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->first();

        if ($existingSchedule) {
            throw new Exception('Ya existe un horario con el mismo día y hora.');
        }
    }

    public static function validateUpdateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        $existingSchedule = MassSchedule::where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('id', '!=', $request->id)
            ->first();

        if ($existingSchedule) {
            throw new Exception('Ya existe un horario con el mismo día y hora.');
        }
    }
}
