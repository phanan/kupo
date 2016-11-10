<?php

use App\Http\Requests\CheckRequest;
use App\Services\Checker;

Route::get('/', function () {
    return view('home');
});
