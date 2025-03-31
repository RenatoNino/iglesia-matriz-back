<?php

namespace App\Http\Modules\SystemConfiguration\Repositories;

use App\Http\Modules\Auth\Helpers\RoleHelper;
use App\Http\Modules\SystemConfiguration\Helpers\SystemConfigurationHelper;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SystemConfigurationRepository
{
    public static function general()
    {
        $application_name = SystemConfiguration::byKey('key', 'application_name');
        $logo = SystemConfiguration::byKey('key', 'logo');
        $favicon = SystemConfiguration::byKey('key', 'favicon');
        $banner = SystemConfiguration::byKey('key', 'banner');
        $primary_color = SystemConfiguration::byKey('key', 'primary_color');

        $dates = [
            $application_name->updated_at,
            $logo->updated_at,
            $favicon->updated_at,
            $banner->updated_at,
            $primary_color->updated_at,
        ];
        $last_date = max($dates)->format('Y-m-d H:i:s');

        $result = [
            'app_name' => $application_name->value,
            'logo' => $logo->value,
            'favicon' => $favicon->value,
            'banner' => $banner->value,
            'primary_color' => $primary_color->value,
            'last_date' => $last_date,
        ];

        return $result;
    }

    public static function list()
    {
        $system_configuration = SystemConfiguration::select([
            'key',
            'name',
            'type',
            'value',
        ])
            ->get()
            ->each(function ($item) {
                SystemConfigurationHelper::setTypeValue($item);
            });

        return $system_configuration;
    }

    public static function update(string $key, Request $request)
    {
        RoleHelper::validateAdminAccess();

        SystemConfigurationHelper::validateUpdateRequest($key, $request);

        $system_configuration = SystemConfiguration::byKey('key', $key);

        if (in_array($key, ['logo', 'favicon', 'banner'])) {

            if ($system_configuration->value) {
                $system_configuration->value = 'public/' . $system_configuration->value;

                if (Storage::exists($system_configuration->value)) {
                    Storage::delete($system_configuration->value);
                }
            }

            if (!$request->value || $request->value === 'null') {
                $request->merge(['path' => $system_configuration->value]);
                self::deleteImage($request);
                $system_configuration->update(['value' => null]);
                return "$system_configuration->name eliminado correctamente";
            }

            $file = $request->file('value');
            $path = $file->store('public/' . $key);
            $path = str_replace('public/', '', $path);

            $system_configuration->update(['value' => $path]);

            return $system_configuration->value;
        }

        $system_configuration->update(['value' => $request->value === 'null' ? null : $request->value]);

        return "$system_configuration->name actualizado correctamente";
    }

    public static function uploadImage(Request $request)
    {
        RoleHelper::validateAdminAccess();

        SystemConfigurationHelper::validateUploadImageRequest($request);

        $file = $request->file('file');
        $path = $file->store('public/images');
        $path = str_replace('public/', '', $path);

        return $path;
    }

    public static function deleteImage(Request $request)
    {
        RoleHelper::validateAdminAccess();

        if (!str_starts_with($request->path, 'default/')) {

            $path = 'public/' . $request->path;

            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        return "Imagen eliminada correctamente";
    }
}
