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

    <style>

        .full-height {
            min-height: 100%;
        }

        .flex-column {
            display: flex;
            flex-direction: column;
        }

        .links {
            padding: 1em;
            text-align: right;
        }

        .links a {
            text-decoration: none;
        }

        .links button {
            background-color: #3097D1;
            border: 0;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-family: 'Open Sans';
            font-size: 14px;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            width: 100px;
        }
    </style>
</head>
<body>
    @if(!Auth::check())
        <div class="full-height flex-column">
            <nav class="links">
                <a href="/login" style="margin-right: 15px;">
                    <button>
                        Login
                    </button>
                </a>

                <a href="/register">
                    <button>
                        Register
                    </button>
                </a>
            </nav>
        </div>
    @else
        @extends('spark::layouts.app')

        @section('content')
            <router-link to="/grocery-lists">Grocery Lists</router-link>
            <router-view></router-view>
        @endsection
    @endif
</body>
</html>
