<?php

namespace App\Http\Modules\Auth\Repositories;

use App\Http\Services\SessionManagerService;
use App\Models\Role;
use App\Models\User;
use Exception;

class RoleRepository
{
    public static function list()
    {
        $roles = Role::select()
            ->get();

        return $roles;
    }

    public static function change(int $id)
    {
        $session = SessionManagerService::get();

        $user = User::find($session->id);
        $rol = Role::byKey('id', $id);

        $roles = $user->roles()->pluck('rol.id')->toArray();

        if (!in_array($rol->id, $roles)) {
            throw new Exception("No tienes el rol de $rol->name");
        }

        $user->update([
            'rol_id' => $rol->id
        ]);

        return $rol->id;
    }
}
