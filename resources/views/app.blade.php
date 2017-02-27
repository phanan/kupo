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
        <div id="app"></div>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
