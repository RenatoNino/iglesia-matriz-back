<?php

namespace App\Http\Modules\Intention\Controllers;

use App\Http\Modules\Intention\UseCases\IntentionRegisterUseCases;
use Illuminate\Http\Request;

class IntentionRegisterController
{
    public function parameters()
    {
        return IntentionRegisterUseCases::parameters();
    }

    public function list(Request $request)
    {
        return IntentionRegisterUseCases::list($request);
    }

    public function create(Request $request)
    {
        return IntentionRegisterUseCases::create($request);
    }

    public function update(Request $request, int $id)
    {
        return IntentionRegisterUseCases::update($request, $id);
    }

    public function updateIntention(Request $request, int $id)
    {
        return IntentionRegisterUseCases::updateIntention($request, $id);
    }

    public function deleteIntention(int $id)
    {
        return IntentionRegisterUseCases::deleteIntention($id);
    }

    public function delete(int $id)
    {
        return IntentionRegisterUseCases::delete($id);
    }
}
