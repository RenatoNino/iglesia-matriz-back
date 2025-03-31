<?php

namespace App\Http\Modules\Auth\Helpers;

use App\Http\Modules\SystemConfiguration\Helpers\SystemConfigurationHelper;
use App\Models\Menu;
use App\Models\Option;
use App\Models\SystemConfiguration;
use App\Models\User;

class MenuHelper
{
    public static function listByUser(User $user)
    {
        $role_ids = $user->roles->pluck('id')->toArray();

        $menus = Menu::select('menu.id', 'menu.name')
            ->join('option', 'menu.id', 'option.menu_id')
            ->join('role_option', 'option.id', 'role_option.option_id')
            ->whereIn('role_option.role_id', $role_ids)
            ->groupBy('menu.id', 'menu.name')
            ->get();

        $result = [];
        foreach ($menus as $menu) {
            $options = self::getOptions($role_ids, $menu->id, null);

            if (count($options) == 0) continue;

            $menu->options = $options;
            $result[] = $menu;
        }

        // $links = SystemConfiguration::select([
        //     'key',
        //     'name',
        //     'value',
        // ])
        //     ->whereIn('key', ['virtual_library_url'])
        //     ->whereNotNull('value')
        //     ->get();

        // foreach ($links as $link) {
        //     SystemConfigurationHelper::setTypeValue($link);
        //     $result[] = [
        //         'id' => $link->key,
        //         'name' => $link->key,
        //         'url' => $link->value,
        //     ];
        // }

        return $result;
    }

    public static function getOptions(array $role_ids, $menu_id, $option_id)
    {
        $options = Option::select([
            'option.id',
            'option.name',
            'option.name_url',
            'option.icon',
        ])
            ->join('role_option', 'option.id', 'role_option.option_id')
            ->where('option.menu_id', $menu_id)
            ->whereIn('role_option.role_id', $role_ids)
            ->where('option.is_visible', true)
            ->where('option.option_id', $option_id)
            ->get();

        foreach ($options as $option) {
            $option->options = self::getOptions($role_ids, $menu_id, $option->id);
        }

        return $options;
    }
}
