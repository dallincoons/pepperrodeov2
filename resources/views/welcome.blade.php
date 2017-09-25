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
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700" rel="stylesheet">

    <style>
        h2, h3, h4, h5, h6, p, a {
            font-family: 'Roboto', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff4f0;
        }

        #spark-app {
            display: flex;
        }

        .nav-wrapper {
            display: flex;
            flex-direction: column;
            padding-right: 5%;
            text-align: center;
            width: 20%;
            margin-top: 11px;

        }

        .nav-links {
            background: #ffffff;
            margin-top: 1%;
            display: flex;
            flex-direction: column;
            position: relative;
            text-align: left;
            padding-left: 10px;
            border-radius: 10px;
            -webkit-box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
            -moz-box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
            box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
        }

        .nav-links a {
            color: #4f4f4f;
            font-size: 1.2em;
            padding: 2% 2% 4% 2%;
        }

        .nav-links a:hover {
            color: #4f4f4f;
            text-decoration: none;
            cursor: pointer;
        }


        .nav-brand {
            font-family: 'Dancing Script', cursive;
            color: #ff4b2e;
            margin-bottom: -1%;
            z-index: 2;
            font-weight: 700;
            margin-top: 0;
        }

        .nav-link {
            color: #4f4f4f;
            font-size: 1.2em;
            border-bottom: 1px solid #4f4f4f;
            width: 80%;
            padding: 2%;
            transition: border-bottom 2ms;
        }

        .nav-link:hover {
            border-bottom: 1px solid #ff4b2e;
            color: #4f4f4f;
            text-decoration: none;
            transition: border-bottom 2ms;
        }

        .nav-line {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 5px;
            width: 100%;
            background-color: #ff4b2e;
            border-radius: 0 0 10px 10px;
        }

        .main-wrapper {
            display: flex;
            width:40%;
            margin-top: 10%;
        }

        .picture-section {
            width: 60%;
            background: #ff4b2e;
        }

        .sign-in-section {
            display: flex;
            text-align: right;
            width: 35%;
            background: #ffffff;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-direction: column;
            position: relative;
        }


        .brand{
            font-family: 'Dancing Script', cursive;
            font-weight: 700;
            font-size: 3em;
            color: #ff4b2e;
        }

        .links {
            text-align: right;
            width: 100%;
            background: rgba(255,255,255,.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40%;
        }

        .links a {
            text-decoration: none;
            background: rgba(255,255,255,.4);
            color: #ff4b2e;
            font-size: 1.5em;
            font-weight: 500;
            cursor: pointer;
            width: 60%;
            height: 35%;
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
        .line {
            width: 100%;
            height: 10px;
            background: #ff4b2e;
            align-self: flex-end;
            position: absolute;
            bottom: 0;
        }

        .edit-item {
            background: #ffffff;
            margin-top: 25%;
            display: flex;
            flex-direction: column;
            position: relative;
            text-align: left;
            padding-left: 10px;
            border-radius: 10px;
            -webkit-box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
            -moz-box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
            box-shadow: 0 0 10px 2px rgba(27,26,26,0.14);
        }
    </style>
</head>
<body>
    @extends('spark::layouts.app')

    @section('content')

        <div class="nav-wrapper">
            <h1 class="nav-brand">Pepper Rodeo</h1>
            <div class="nav-links">
                <router-link to="/grocery-lists" class="nav-link">Grocery Lists</router-link>
                <router-link to="/grocery-list/create" class="nav-link">Create Grocery List</router-link>
                <a>Log Out</a>
                <div class="nav-line"></div>
            </div>
            <router-view name="navigation"></router-view>

        </div>

        <router-view></router-view>
    @endsection
</body>
</html>
