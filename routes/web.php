<?php


Route::get('/', function (\Illuminate\Http\Request $request) {
    $url = filter_var($request->get('url'), FILTER_VALIDATE_URL);

    return view('app', ['url' => $url]);
});
