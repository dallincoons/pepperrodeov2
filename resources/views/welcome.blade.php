<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700|Roboto:300,400,500" rel="stylesheet">


    <style>
        h2, h3, h4, h5, h6, p, a {
            font-family: 'Roboto', sans-serif;
        }
        .full-height {
            min-height: 100vh;
            background-image: url("/img/pepperrodeo_background_img.jpg");
            -webkit-background-size: cover;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .brand{
            font-family: 'Dancing Script', cursive;
            font-weight: 700;
            font-size: 5em;
            color: #ff4b2e;
        }

        .links {
            padding: 1em 1em 5em 1em;
            text-align: right;
            width: 35%;
            background: rgba(255,255,255,.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-direction: column;
            align-items: center;
        }

        .links a {
            text-decoration: none;
            background: rgba(255,255,255,.4);
            color: #ff4b2e;
            font-size: 1.5em;
            font-weight: 500;
            cursor: pointer;
            width: 60%;
            height: 75%;
            text-align: center;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            transition: background-color 0.5s ease;
            border: 1px solid #ff4b2e;
        }
        .links a:hover {
            background: #ffffff;
            color: #ff4b2e;
            text-decoration: none;
        }
    </style>
</head>
<body>
    @if(!Auth::check())
        <div class="full-height">
            <nav class="links">
            <h1 class="brand">Pepper Rodeo</h1>
                <a href="/login">Login</a>

                <a href="/register">Sign Up</a>
            </nav>
        </div>

    @else
        @extends('spark::layouts.app')

        @section('content')
            <router-link to="/grocery-lists">Grocery Lists</router-link>
            <router-link to="/grocery-list/create">Create Grocery List</router-link>
            <router-view></router-view>
        @endsection
    @endif
</body>
</html>
