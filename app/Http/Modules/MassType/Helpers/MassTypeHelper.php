<?php

namespace App\Http\Modules\MassType\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MassTypeHelper
{
    public static function validateCreateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:mass_type,name',
            'slug' => 'required|string|max:255|unique:mass_type,slug',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateUpdateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:mass_type,name,' . $request->id,
            'slug' => 'required|string|max:255|unique:mass_type,slug,' . $request->id,
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
