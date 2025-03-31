<?php

namespace App\Http\Modules\SystemConfiguration\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\SystemConfiguration\UseCases\SystemConfigurationUseCases;
use Illuminate\Http\Request;

class SystemConfigurationController extends Controller
{
    public function general()
    {
        return SystemConfigurationUseCases::general();
    }

    public function list()
    {
        return SystemConfigurationUseCases::list();
    }

    public function update(string $key, Request $request)
    {
        return SystemConfigurationUseCases::update($key, $request);
    }

    public function uploadImage(Request $request)
    {
        return SystemConfigurationUseCases::uploadImage($request);
    }

    public function deleteImage(Request $request)
    {
        return SystemConfigurationUseCases::deleteImage($request);
    }
}
