<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- ********************************************************************************************* -->
<nav class="navbar navbar-expand-sm navbar-dark bg-primary mb-3 navbar-laravel">
    <div class="container">
  <a class="navbar-brand" >Projet Space</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- @if (Route::has('login')) -->
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item ">
      
        <a class="nav-link" href="{{ url('/home') }}">Home</a>
      
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/about') }}">About</a>
      </li>
    </ul>
    @guest
    <ul class="navbar-nav ml-auto">
    <!-- @auth -->
    <!-- @else -->
    
   
      <li class="nav-item">
        <a href="{{ route('login') }}" class="nav-link">Login</a>
        
      </li>
        <li class="nav-item">
        <a href="{{ route('register') }}" class="nav-link">Register</a>
      </li>
    <!-- @endauth -->
    </ul>
    @else
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id='navbarDropdownMenuLink'>project Ideas</a>
            <div class="dropdown-menu">
                <a href="{{ url('/project/ideas') }}" class="dropdown-item">Ideas</a>
                <a href="{{ url('project/create') }}" class="dropdown-item">Add Ideas</a>
            </div>
    </ul>
    @if ( auth()->user()->isAdmin() )
    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a href="{{ url('/admin') }}" class="nav-link btn btn-danger btn-block">Admin</a>
        
      </li>
      </ul>
    @else

    @endif
    <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            </ul>              
    @endguest
   
  </div>
  <!-- @endif -->
 
  </div>
</nav>
<!-- *********************************************************************************************************** -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
