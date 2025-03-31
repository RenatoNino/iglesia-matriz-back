<?php

namespace App\Http\Utils;

class ResponseUtil
{
    public static function success($data = null, $message = 'Operación exitosa')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function error($message = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ]);
    }

    public static function unauthorized()
    {
        return response()->json([
            'error' => 'UnAuthenticated',
        ], 401);
    }

    public static function notFound($message)
    {
        return response()->json([
            'error' => 'NotFound',
            'message' => $message,
        ], 404);
    }
}
