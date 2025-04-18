<?php

use App\Http\Middlewares\AuthMiddleware;
use App\Http\Modules\Auth\Controllers\AuthController;
use App\Http\Modules\Auth\Controllers\MenuController;
use App\Http\Modules\Auth\Controllers\RoleController;
use App\Http\Modules\Intention\Controllers\IntentionController;
use App\Http\Modules\Intention\Controllers\IntentionRegisterController;
use App\Http\Modules\MassSchedule\Controllers\MassScheduleController;
use App\Http\Modules\SystemConfiguration\Controllers\SystemConfigurationController;
use App\Http\Modules\Testing\TestingController;
use App\Http\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Modules\IntentionType\Controllers\IntentionTypeController;

#rutas publicas
Route::controller(SystemConfigurationController::class)
    ->prefix('system-configuration')
    ->group(function () {
        Route::get('general', 'general');
    });

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('login', 'login');
        Route::put('reset/password', 'resetPassword');
        Route::get('check/reset/password', 'checkResetPassword');
        Route::put('change/password', 'changePassword');
    });

#rutas privadas
Route::group(['middleware' => [AuthMiddleware::class]], function () {
    Route::controller(TestingController::class)
        ->prefix('testing')
        ->group(function () {
            Route::get('', 'test');
        });

    Route::controller(SystemConfigurationController::class)
        ->prefix('system-configuration')
        ->group(function () {
            Route::get('list', 'list');
            Route::get('key/{key}', 'key');
            Route::post('update/{key}', 'update');
            Route::post('upload/image', 'uploadImage');
            Route::delete('delete/image', 'deleteImage');
        });

    Route::controller(RoleController::class)
        ->prefix('role')
        ->group(function () {
            Route::get('list', 'list');
            Route::put('change/{id}', 'change');
        });

    Route::controller(MenuController::class)
        ->prefix('menu')
        ->group(function () {
            Route::get('', 'get');
        });

    Route::controller(UserController::class)
        ->prefix('user')
        ->group(function () {
            Route::get('params', 'params');
            Route::post('list', 'list');
            Route::post('create', 'create');
            Route::put('update/{id}', 'update');
            Route::put('change/password/{id}', 'changePassword');
            Route::post('change/photo/{id}', 'changePhoto');
            Route::delete('delete/photo/{id}', 'deletePhoto');
            Route::put('reset/password/{id}', 'resetPassword');
            Route::put('disable/{id}', 'disable');
            Route::delete('delete/{id}', 'delete');
        });


    Route::controller(IntentionTypeController::class)
        ->prefix('intention-type')
        ->group(function () {
            Route::get('', 'list');
            Route::post('', 'create');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'delete');
        });

    Route::controller(MassScheduleController::class)
        ->prefix('mass-schedule')
        ->group(function () {
            Route::get('', 'list');
            Route::post('', 'create');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'delete');
        });

    Route::controller(IntentionRegisterController::class)
        ->prefix('intention-register')
        ->group(function () {
            Route::get('parameters', 'parameters');
            Route::post('list', 'list');
            Route::post('create', 'create');
            Route::put('update/{id}', 'update');
            Route::put('update/intention/{id}', 'updateIntention');
            Route::delete('delete/intention/{id}', 'deleteIntention');
            Route::delete('delete/{id}', 'delete');
        });

    Route::controller((IntentionController::class))
        ->prefix('intention')
        ->group(function () {
            Route::get('parameters', 'parameters');
            Route::post('list', 'list');
            Route::post('create', 'create');
            Route::put('{id}', 'update');
            Route::delete('{id}', 'delete');
        });
});
