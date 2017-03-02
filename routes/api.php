<?php

use App\Http\Requests\CheckRequest;
use App\Services\Checker;

Route::get('check', function (CheckRequest $request, Checker $checker) {
    $results = $checker->validate($request->url);

    return response()->json(iterator_to_array($results));
})->name('check');
