<!doctype html>
<html lang="en" class="h-100">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Pet Shelter</title>
</head>
<body class="bg-white" style="height: calc(100vh - 60px);">
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('imgs/paw.svg') }}" alt="" class="me-2" style="height: 24px"/>
            <span>SDU's Pet Shelter</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Home</a>
                </li>

                <!-- Task 1 Authorization, elements should appear for logged users only -->

                    <li class="nav-item">
                        <a class="nav-link adoption-mine" href="{{ route('adoptions.mine') }}">My Adoptions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link adoption-create" href="{{ route('adoptions.create') }}">New Listing</a>
                    </li>
                <!-- Task 1 Authorization-->
            </ul>
            <ul class="navbar-nav d-flex">
                <!-- Task 1 Authorization, elements should appear for guest users only -->
                    <li class="nav-item">
                        <!-- Task 2 Guest, step 2: add correct link in href -->
                        <a class="nav-link register-link" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <!-- Task 3 Guest, step 2: add correct link in href -->
                        <a class="nav-link login-link" href="{{ route('login') }}">Login</a>
                    </li>
                <!-- Task 1 Authorization-->

                <!-- Task 1 Authorization, elements should appear for logged users only -->
                    <!-- Task 1 User, step 1: add name of logged user-->
                @auth()
                <span class="navbar-text text-black me-4 user-name">{{auth()->user()->name}}</span>

                <li class="nav-item">
                        <!-- Task 2 User, step 3: add correct link-->
                        <a class="nav-link logout-link" href="{{route('logout')}}">Log out</a>
                    </li>
                @endauth
                <!-- Task 1 Authorization-->
            </ul>
        </div>
    </div>
</nav>
@yield('content')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>
