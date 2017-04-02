<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.description') }}">
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,600|Roboto Mono">
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

    <script>
        window.Laravel = <?= json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        window.appMeta = <?= json_encode([
            'name' => config('app.name'),
            'description' => config('app.description'),
        ]); ?>;
    </script>
</head>
<body>

<div class="yoast-container">

    <div class="site-inner">
        <div class="wrap">
            <div class="content-sidebar-wrap">
                <div id="input" class="form-container">
                    <div id="inputForm" class="inputForm">
                        <input type="hidden" id="locale" name="locale" value="{{ $locale }}"/>
                        <input type="hidden" id="focusKeyword" name="focusKeyword"  value="{{ $focusKeyword }}"/>

                        <input type="hidden" id="content" name="content" value="{{ $content }}" />
                        <input type="hidden" id="title" name="title"  value="{{ $title }}" />
                        <input type="hidden" id="metaDesc" name="metaDesc" value="{{ $metaDesc }}" />
                        <input type="hidden" id="urlPath" name="urlPath" value="{{ $urlPath }}" />
                        <input type="hidden" id="baseUrl" name="baseUrl" value="{{ $baseUrl }}" />
                    </div>
                    <form id="snippetForm" class="snippetForm">
                        <div id="snippet" class="output">

                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    window.onload = function(){
        doYoast();
    }
</script>
</body>
</html>
