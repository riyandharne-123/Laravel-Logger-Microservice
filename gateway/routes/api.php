<?php

use Illuminate\Support\Facades\Route;

Route::post('test', 'App\Http\Controllers\TestController@test')->middleware('logger');
