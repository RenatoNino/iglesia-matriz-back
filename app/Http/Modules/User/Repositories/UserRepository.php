<?php

namespace App\Http\Modules\User\Repositories;

use App\Http\Modules\Auth\Enums\RoleEnum;
use App\Http\Modules\Auth\Helpers\RoleHelper;
use App\Http\Modules\User\Helpers\UserHelper;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    public static function params()
    {
        $documents = Person::select('document_type')
            ->distinct()
            ->pluck('document_type')
            ->toArray();

        $roles = Role::select('id', 'name')
            ->get();

        $result = [
            'documents' => $documents,
            'roles' => $roles,
        ];

        return $result;
    }

    public static function list(Request $request)
    {
        RoleHelper::validateAdminAccess();

        UserHelper::validateListRequest($request);

        $users = User::select([
            'user.id',
            'user.avatar as photo',
            'person.names',
            'person.phone',
            'person.document_type',
            'person.document_number',
            'user.email',
            'user.is_active',
        ])
            ->join('role_user', 'user.id', 'role_user.user_id')
            ->join('role', function ($join) use ($request) {
                $join->on('role_user.role_id', 'role.id')
                    ->where('role.id', $request->role_id);
            })
            ->join('person', 'person.id', 'user.person_id')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('person.names', 'like', "%$request->search%")
                        ->orWhere('person.phone', 'like', "%$request->search%")
                        ->orWhere('person.email', 'like', "%$request->search%");
                });
            })
            ->orderBy('person.names')
            ->distinct()
            ->paginate($request->size, ['*'], 'page', $request->page);

        $result = [
            'page' => $request->page,
            'size' => $request->size,
            'total' => $users->total(),
            'users' => $users->items(),
        ];

        return $result;
    }

    public static function create(Request $request)
    {
        RoleHelper::validateAdminAccess();

        UserHelper::validateCreateRequest($request);

        $person = Person::create([
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'names' => $request->names,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        $user = User::create([
            'person_id' => $person->id,
            'email' => $request->email,
            'password' => Hash::make($request->document_number),
        ]);

        $user->roles()->attach($request->role_ids);

        return 'Usuario creado correctamente';
    }

    public static function update(int $id, Request $request)
    {
        $user = UserHelper::validateAccess($id);

        $roles = $user->roles();

        $is_admin = $roles
            ->where('role.id', RoleEnum::ADMIN)
            ->exists();

        UserHelper::validateUpdateRequest($request, $user, $is_admin);

        $columns = $is_admin ? [
            'document_type' => $request->document_type,
            'document_number' => $request->document_number,
            'names' => $request->names,
            'phone' => $request->phone,
            'email' => $request->email,
        ] : [
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $user->person->update($columns);

        $user->update([
            'email' => $request->email,
        ]);

        return 'Usuario actualizado correctamente';
    }

    public static function changePassword(int $id, Request $request)
    {
        $user = UserHelper::validateAccess($id);

        UserHelper::validateChangePasswordRequest($request);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return 'Contraseña actualizada correctamente';
    }

    public static function changePhoto(int $id, Request $request)
    {
        $user = UserHelper::validateAccess($id);

        UserHelper::validateChangePhotoRequest($request);

        if ($user->avatar) {
            $user->avatar = 'public/' . $user->avatar;

            if (Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
        }

        $file = $request->file('file');
        $path = $file->store('public/user');
        $path = str_replace('public/', '', $path);

        $user->update([
            'avatar' => $path,
        ]);

        return $path;
    }

    public static function deletePhoto(int $id)
    {
        $user = UserHelper::validateAccess($id);

        if ($user->avatar) {
            $user->avatar = 'public/' . $user->avatar;

            if (Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
        }

        $user->update([
            'avatar' => null,
        ]);

        return "Foto eliminada correctamente";
    }

    public static function resetPassword(int $id)
    {
        $user = UserHelper::validateAccess($id);

        $user->update([
            'password' => Hash::make($user->person->document_number),
        ]);

        return 'Contraseña restablecida correctamente';
    }

    public static function disable(int $id)
    {
        $user = UserHelper::validateDisableOrDeleteAccess($id);

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        return "Usuario " . ($user->is_active ? "habilitado" : "deshabilitado") . " correctamente";
    }

    public static function delete(int $id)
    {
        $user = UserHelper::validateDisableOrDeleteAccess($id);

        $roles = $user->roles();

        $is_admin = $roles
            ->where('role.id', RoleEnum::ADMIN)
            ->exists();

        if (!$is_admin) {
            throw new Exception('Solo se pueden eliminar usuarios administradores');
        }

        $count = $roles->count();
        if ($count > 1) {
            $roles->detach(RoleEnum::ADMIN);

            return "Usuario eliminado como administrador correctamente";
        }

        $roles->detach();
        $user->delete();

        return "Usuario eliminado correctamente";
    }
}
