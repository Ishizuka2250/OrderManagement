<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ secure_asset('css/reset.css')}}">
  <link rel="stylesheet" href="{{ secure_asset('css/body.css')}}">
  <link rel="stylesheet" href="{{ secure_asset('css/awesome_notifications.css')}}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href=”https://fonts.googleapis.com/css?family=Noto+Sans+JP&amp;subset=japanese” rel=”stylesheet”>
  <title>WaitingNoSystem</title>
</head>
  <body>
    <div id="app">
      <router-view></router-view>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>