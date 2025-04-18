<?php

namespace App\Http\Modules\Intention\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\Intention\UseCases\IntentionUseCases;
use Illuminate\Http\Request;

class IntentionController extends Controller
{
    public function parameters()
    {
        return IntentionUseCases::parameters();
    }

    public function list(Request $request)
    {
        return IntentionUseCases::list($request);
    }

    public function create(Request $request)
    {
        return IntentionUseCases::create($request);
    }

    public function update(Request $request, int $id)
    {
        return IntentionUseCases::update($request, $id);
    }

    public function delete(int $id)
    {
        return IntentionUseCases::delete($id);
    }
}
