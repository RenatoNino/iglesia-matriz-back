<?php

namespace App\Http\Modules\Intention\Helpers;

use App\Http\Modules\Auth\Enums\RoleEnum;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IntentionRegisterHelper
{
    public static function validateListRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:Y-m-d|before_or_equal:today',
            'page' => 'required|integer|gt:0',
            'size' => 'required|integer|gt:0',
            'search' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateCreateRequest(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'client_name' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:255',
            'amount_charged' => 'required|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'receipt_type_id' => 'required|exists:receipt_type,id',
            'payment_method_id' => 'required|exists:payment_method,id',
            'intentions' => 'required|array|min:1',
            'intentions.*.mass_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'intentions.*.mass_schedule_id' => 'required|exists:mass_schedule,id',
            'intentions.*.intention_type_id' => 'required|exists:intention_type,id',
            'intentions.*.person_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$user->hasRole(RoleEnum::ADMIN) && $request->has('total_amount')) {
            throw new Exception("El monto total no puede ser modificado por un usuario que no es administrador.");
        }
    }

    public static function validateUpdateRequest(Request $request, User $user)
    {
        if (!$user->hasRole(RoleEnum::ADMIN) && $request->has('total_amount')) {
            throw new Exception("Un registro de intenciones solo puede ser modificado por el administador.");
        }

        $validator = Validator::make($request->all(), [
            'client_name' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:255',
            'total_amount' => 'nullable|numeric|min:0',
            'amount_charged' => 'nullable|numeric|min:0|gte:total_amount',
            'receipt_type_id' => 'nullable|exists:receipt_type,id',
            'payment_method_id' => 'nullable|exists:payment_method,id',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateUpdateIntentionRequest(Request $request, User $user)
    {
        if (!$user->hasRole(RoleEnum::ADMIN) && $request->has('total_amount')) {
            throw new Exception("Una intención solo puede ser modificada por el administador.");
        }

        $validator = Validator::make($request->all(), [
            'mass_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'mass_schedule_id' => 'required|exists:mass_schedule,id',
            'intention_type_id' => 'required|exists:intention_type,id',
            'person_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
