<?php

namespace App\Http\Modules\SystemConfiguration\Helpers;

use Exception;
use App\Http\Enums\DaysOfWeek;
use App\Http\Enums\ParameterTypes;
use App\Models\SystemConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SystemConfigurationHelper
{
    public static function getValueByKey($key)
    {
        $parameter = SystemConfiguration::byKey('key', $key);

        self::setTypeValue($parameter);

        return $parameter->value;
    }

    public static function setTypeValue(SystemConfiguration $parameter)
    {
        switch ($parameter->type) {
            case ParameterTypes::NUMBER:
                $parameter->value = (float) $parameter->value;
                break;
            case ParameterTypes::BOOLEAN:
                $parameter->value = (bool) $parameter->value;
                break;
            case ParameterTypes::ARRAY:
                $parameter->value = (array) json_decode($parameter->value);
                break;
            case ParameterTypes::JSON:
                $parameter->value = (object) json_decode($parameter->value);
                break;
            default:
                $parameter->value = (string) $parameter->value;
                break;
        }
    }

    public static function getSiteName()
    {
        $key = 'application_name';
        $value = self::getValueByKey($key);

        return $value;
    }

    public static function getSiteLogo()
    {
        $key = 'logo';
        $value = self::getValueByKey($key);

        $path = 'public/' . $value;

        return Storage::exists($path) ? $value : null;
    }

    public static function validateUpdateRequest(string $key, Request $request)
    {
        if (in_array($key, ['logo', 'favicon', 'banner'])) {
            if ($request->hasFile('value')) {
                $rules["value"] = "file|mimes:jpeg,jpg,png";
            } else {
                $rules["value"] = "nullable";
            }
        } else {
            $rules["value"] = "required|string";
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    public static function validateUploadImageRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|image',
        ]);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }
}
