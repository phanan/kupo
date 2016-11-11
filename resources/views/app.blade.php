<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A simple site launch checklist checker">
        <title>Website Deployment Checklist</title>
        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,600|Roboto Mono">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script>
            window.Laravel = <?= json_encode([
             'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body>
        <div id="app"></div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/1.2.3/velocity.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
