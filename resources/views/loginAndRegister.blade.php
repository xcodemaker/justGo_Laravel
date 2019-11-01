<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>JustGo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-sm navbar-dark bg-primary mb-3">
    <div class="container">
  <a class="navbar-brand" href="{{ route('home') }}">JustGo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  @if (Route::has('login'))
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item ">
      
        <a class="nav-link" href="{{ url('/home') }}">Home</a>
      
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/about') }}">About</a>
      </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
    @auth
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
    @else
      <li class="nav-item">
        <a href="{{ route('login') }}" class="nav-link">Login</a>
        
      </li>
        <li class="nav-item">
        <a href="{{ route('register') }}" class="nav-link">Register</a>
      </li>
    @endauth
    </ul>
  </div>
  @endif
 
  </div>
</nav>
<div class="container">
    
    
@auth
    <div class="jumbotron text-center">
    <h1 class="display-3">welcome</h1>
    <p class="lead">Jot down ideas for your next  projects</p>
    <a href="{{ url('project/create') }}" class="btn btn-dark btn-lg">Add project Idea</a>

@endauth
<div class="jumbotron text-center">
    <h1 class="display-3">welcome</h1>
    <p class="lead">Jot down ideas for your next  projects</p>
    <a href="{{ url('login') }}" class="btn btn-dark btn-lg">Add project Idea</a>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>