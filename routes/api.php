<?php

use App\Http\Requests\CheckRequest;
use App\Services\Checker;

Route::get('check', function (CheckRequest $request, Checker $checker) {
    $checker->setUrl($request->url);

    return response()->json(iterator_to_array($checker->validate()));
})->name('check');
