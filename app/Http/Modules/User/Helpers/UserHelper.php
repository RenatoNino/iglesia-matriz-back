<?php

namespace App\Http\Modules\User\Helpers;

use App\Http\Modules\Auth\Enums\RoleEnum;
use App\Http\Services\SessionManagerService;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserHelper
{
    public static function validateListRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "page"              => "required|integer|gt:0",
            "size"              => "required|integer|gt:0",
            "role_id"           => "required|numeric|exists:role,id",
            "search"            => "nullable|string",
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateAccess(int $id)
    {
        $session = SessionManagerService::get();
        $user_login = User::find($session->user_id);

        $is_admin = array_intersect([RoleEnum::ADMIN], $user_login->roles()->pluck('role.id')->toArray());

        $user = User::byKey('id', $id);

        if (!$is_admin && $user_login->id !== $user->id) {
            throw new Exception("No tienes permisos para realizar esta acción");
        }

        return $user;
    }

    public static function validateCreateRequest(Request $request)
    {
        $roles = implode(',', [RoleEnum::ADMIN]);

        $validator = Validator::make($request->all(), [
            "document_type"     => "required|string|exists:person,document_type",
            "document_number"   => "required|string|size:8|unique:person,document_number",
            "names"             => "required|string",
            "phone"             => "required|string|size:9",
            "email"             => "required|email|unique:user,email",
            "role_ids"           => "required|array",
            "role_ids.*"         => "required|numeric|exists:role,id|in:" . $roles,
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateUpdateRequest(Request $request, User $user, $is_admin)
    {
        $exceptIdPerson = $user->person_id;
        $exceptIdUser = $user->id;
        $required = $is_admin ? 'required' : 'nullable';

        $validator = Validator::make($request->all(), [
            "document_type"     => "$required|string|exists:person,document_type",
            "document_number"   => "$required|string|size:8|unique:person,document_number,$exceptIdPerson",
            "names"             => "$required|string",
            "phone"             => "required|string|size:9",
            "email"             => "required|email|unique:user,email,$exceptIdUser",
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateChangePasswordRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "password" => "required|string|min:8",
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateChangePhotoRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateDisableOrDeleteAccess(int $id)
    {
        $session = SessionManagerService::get();

        $user_login = User::find($session->user_id);

        $user = User::byKey('id', $id);

        if (!in_array($user_login->rol_id, [RoleEnum::ADMIN])) {
            throw new Exception("No tienes permisos para realizar esta acción");
        }

        if ($user_login->id == $user->id) {
            throw new Exception("No puedes desactivar o eliminar tu propio usuario");
        }

        return $user;
    }
}
