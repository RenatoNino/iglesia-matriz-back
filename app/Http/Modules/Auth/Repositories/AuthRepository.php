<?php

namespace App\Http\Modules\Auth\Repositories;

use App\Http\Enums\EmailBodyTemplate;
use App\Http\Modules\Auth\Helpers\AuthHelper;
use App\Http\Modules\Auth\Helpers\MenuHelper;
use App\Http\Services\JWTService;
use App\Http\Services\MailerService;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public static function login(Request $request)
    {
        AuthHelper::validateLoginRequest($request);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new Exception('Credenciales inválidas');
        }

        // Token
        $payload = [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->person->names,
        ];

        $token = JWTService::sign($payload, $request->remember);

        // Profile
        $roles = $user->roles()->select('role.id', 'role.name')->get();

        // Menu
        $menu = MenuHelper::listByUser($user);

        $result = [
            'token' => $token,
            'menu' => $menu,
            'user' => [
                'document_type' => $user->person->document_type,
                'document_number' => $user->person->document_number,
                'names' => $user->person->names,
                'phone' => $user->person->phone,
                'email' => $user->email,
                'photo' => $user->avatar,
            ],
            'roles' => $roles,
        ];

        return $result;
    }

    public static function resetPassword(Request $request)
    {
        AuthHelper::validateResetPasswordRequest($request);

        $user = User::byKey('email', $request->email);

        $payload = [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];

        $reset_password_token = JWTService::sign($payload);

        $user->update([
            'reset_password_token' => $reset_password_token,
        ]);

        $subject = 'Restablecer contraseña';
        $body = EmailBodyTemplate::resetPassword;
        $host = env('APP_FRONTEND_URL');
        self::sendMail([
            'subject' => $subject,
            'body' => $body,
            'name' => $user->person->names,
            'email' => $user->email,
            'url' => $host . '/reset-password?token=' . $reset_password_token,
        ]);

        return 'Solicitud recibida correctamente';
    }

    public static function checkResetPassword(Request $request)
    {
        try {
            JWTService::valid($request->token);
        } catch (Exception $e) {
            throw new Exception('El token para cambiar la contraseña ha expirado, por favor genera otro');
        }
    }

    public static function changePassword(Request $request)
    {
        AuthHelper::validateChangePasswordRequest($request);

        $user = User::byKey('email', $request->email);

        self::checkResetPassword($request->token);

        if (!$user->reset_password_token) {
            throw new Exception('El token para cambiar la contraseña ya ha sido utilizado, por favor genera otro');
        }

        if ($user->reset_password_token != $request->token) {
            throw new Exception('El token para cambiar la contraseña no esta asociado a este correo, por favor verifica tu correo o genera otro');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_token' => null,
            'attempts' => 0,
            'last_attempt' => null,
        ]);

        return 'Contraseña actualizada correctamente';
    }

    private static function sendMail(array $info)
    {
        $info = (object) $info;

        $subject = $info->subject;
        $body = $info->body;

        $name = $info->name;
        $email = $info->email;
        $url = $info->url;

        $body = str_replace('{{name}}', $name, $body);
        $body = str_replace('{{email}}', $email, $body);
        $body = str_replace('{{url}}', $url, $body);

        $data = (object) [
            'subject' => $subject,
            'body' => $body,
            'to' => $email,
        ];

        MailerService::send($data);
    }
}
