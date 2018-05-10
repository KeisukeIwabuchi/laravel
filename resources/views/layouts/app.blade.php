<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
  <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
</head>
<body>
  <div id="app">
    <v-app>
      <v-toolbar class="white">
        <v-toolbar-title @click="Redirect('/')">
          {{ config('app.name', 'Laravel') }}
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-menu class="hidden-md-and-up" bottom left>
          <v-btn icon slot="activator" light>
            <v-icon>more_vert</v-icon>
          </v-btn>
          <v-list>
            @guest
              <v-list-tile @click="Redirect('/login')">
                <v-list-tile-title>Login</v-list-tile-title>
              </v-list-tile>
              <v-list-tile @click="Redirect('/register')">
                <v-list-tile-title>Register</v-list-tile-title>
              </v-list-tile>
            @else
              <v-list-tile>
                <v-list-tile-title>{{ Auth::user()->name }}</v-list-tile-title>
              </v-list-tile>
            @endguest
          </v-list>
        </v-menu>
        <v-toolbar-items class="hidden-sm-and-down">
          @guest
            <v-btn flat @click="Redirect('/login')">Login</v-btn>
            <v-btn flat @click="Redirect('/register')">Register</v-btn>
          @else
            <v-btn flat>{{ Auth::user()->name }}</v-btn>
          @endguest
        </v-toolbar-items>
      </v-toolbar>
      @yield('content')
    </v-app>
  </div>

  <!-- Scripts -->
  <script src="/js/laravel.js"></script>
</body>
</html>
