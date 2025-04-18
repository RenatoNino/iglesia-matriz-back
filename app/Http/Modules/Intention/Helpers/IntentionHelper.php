<?php

namespace App\Http\Modules\Intention\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IntentionHelper
{
    public static function validateListRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mass_date' => 'required|date_format:Y-m-d',
            'search' => 'nullable|string',
            'mass_schedule_id' => 'nullable|exists:mass_schedule,id',
        ]);

        return $validator->validate();
    }

    public static function validateCreateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_name' => 'required|string|max:255',
            'mass_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'mass_schedule_id' => 'required|exists:mass_schedule,id',
            'intention_type_id' => 'required|exists:intention_type,id',
        ]);

        return $validator->validate();
    }

    public static function validateUpdateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'person_name' => 'nullable|string|max:255',
            'mass_date' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'mass_schedule_id' => 'nullable|exists:mass_schedule,id',
            'intention_type_id' => 'nullable|exists:intention_type,id',
        ]);

        return $validator->validate();
    }
}
