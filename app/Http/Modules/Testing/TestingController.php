<?php

namespace App\Http\Modules\Testing;

use App\Http\Controllers\Controller;

class TestingController extends Controller
{
    public function test()
    {
        return 'Ruta para testing';
    }
}
