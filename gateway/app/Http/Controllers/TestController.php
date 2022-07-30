<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request) {
        sleep(rand(0, 3));
        return response()->json($request->all());
    }
}
