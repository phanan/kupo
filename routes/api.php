<?php

use App\Http\Requests\CheckRequest;
use App\Services\Checker;
use Illuminate\Http\JsonResponse;

Route::get('check', static function (CheckRequest $request, Checker $checker): JsonResponse {
    return response()->json($checker->check($request->url));
})->name('check');
