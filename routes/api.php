<?php

use App\Http\Requests\CheckRequest;
use App\Services\Checker;
use App\Services\Insights;
use PhpInsights\InsightsCaller;
use App\Rules\Levels;

Route::get('check', function (CheckRequest $request, Checker $checker, Insights $insights) {
    $results = $checker->validate($request->url);

    $results = iterator_to_array($results);

    if (config('services.google.key')) {
        $insightResults = $insights->validate($request->url, InsightsCaller::STRATEGY_MOBILE);

        $results = array_merge($results, iterator_to_array($insightResults));

        $insightResults = $insights->validate($request->url, InsightsCaller::STRATEGY_DESKTOP);

        $results = array_merge($results, iterator_to_array($insightResults));

        // Remove duplicate entries
        $results = array_map("unserialize", array_unique(array_map("serialize", $results)));
    }

    return response()->json($results);
})->name('check');
