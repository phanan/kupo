<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Website Deployment Checklist</title>
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
