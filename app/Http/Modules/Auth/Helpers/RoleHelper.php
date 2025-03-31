<?php

namespace App\Http\Modules\Auth\Helpers;

use App\Http\Modules\Auth\Enums\RoleEnum;
use App\Http\Services\SessionManagerService;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleHelper
{
    public static function validateAdminAccess()
    {
        $session = SessionManagerService::get();

        $user = User::find($session->user_id);

        $userRoles = $user->roles()->pluck('role.id')->toArray();

        if (!array_intersect([RoleEnum::ADMIN], $userRoles)) {
            throw new Exception("No tienes permisos para realizar esta acción");
        }

        return $user;
    }
}
