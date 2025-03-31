<?php

namespace App\Http\Modules\Auth\Repositories;

use App\Http\Modules\Auth\Helpers\MenuHelper;
use App\Http\Services\SessionManagerService;
use App\Models\User;

class MenuRepository
{
    public static function get()
    {
        $session = SessionManagerService::get();
        $user = User::find($session->user_id);

        $menu = MenuHelper::listByUser($user);

        return $menu;
    }
}
