<?php


Route::get('/', function () {
    return view('app');
});

Route::get('snippet', function (\Illuminate\Http\Request $request ) {

    $url = $request->get('url');

    if (!$url) {
        abort(404);
    }


    $html = \App\Facades\UrlFetcher::fetch($url);
    $crawler = new \App\Crawler($html, $url);

    $description = '';
    if (count($tags = $crawler->filter('meta[name=description]'))) {
        $description = trim($tags->first()->attr('content'));
    }

    $urlParts = parse_url($url);
    return view('snippet', [
        'locale' => config('app.locale'),
        'focusKeyword' => '',
        'content' => null,
        'title' => trim($crawler->filter('head > title')->first()->text()),
        'metaDesc' => trim($description),
        'urlPath' => isset($urlParts['path']) ? $urlParts['path'] : '/',
        'baseUrl' =>  $urlParts['scheme'].'://'.$urlParts['host'],
    ]);
});