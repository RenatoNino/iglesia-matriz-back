<?php

namespace App\Http\Modules\IntentionType\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\IntentionType\UseCases\IntentionTypeUseCases;
use Illuminate\Http\Request;

class IntentionTypeController extends Controller
{
    public function list(Request $request)
    {
        return IntentionTypeUseCases::list($request);
    }

    public function create(Request $request)
    {
        return IntentionTypeUseCases::create($request);
    }

    public function update(int $id, Request $request)
    {
        return IntentionTypeUseCases::update($id, $request);
    }

    public function delete(int $id)
    {
        return IntentionTypeUseCases::delete($id);
    }
}
