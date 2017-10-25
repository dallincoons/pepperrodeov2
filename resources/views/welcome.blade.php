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


</head>
<body class="small-screens-background">
    @extends('spark::layouts.app')

    @section('content')

        <div class="nav-wrapper">
            <h1 class="nav-brand"><device-nav></device-nav>Pepper Rodeo</h1>
            <div class="nav-links">
                <router-link to="/grocery-lists" class="nav-link">Grocery Lists</router-link>
                <router-link to="/grocery-list/create" class="nav-link">Create Grocery List</router-link>
                <router-link to="/recipes" class="nav-link">Recipes</router-link>
                <router-link to="/recipe/create" class="nav-link">Add a Recipe</router-link>

                <a href="/logout">Log Out</a>
                <div class="nav-line"></div>
            </div>
            <router-view name="navigation"></router-view>

        </div>

        <router-view></router-view>
    @endsection
</body>

</html>


