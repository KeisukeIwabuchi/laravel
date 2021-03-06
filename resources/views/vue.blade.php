<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Note</title>

    <!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" href="/css/vuetify.css">
  </head>
  <body>
    <div id="app">
      <router-view/>
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
