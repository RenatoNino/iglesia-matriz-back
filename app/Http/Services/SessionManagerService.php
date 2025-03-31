<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Request;

class SessionManagerService
{

    const JWT_SESSION = 'institucion_jwt_token';

    /**
     * Get session
     *
     * @return collect|null
     */
    public static function get()
    {

        return (object)Request::get(self::JWT_SESSION);
    }
}
