<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    {{--<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Dancing+Script:400,700" rel="stylesheet">--}}
    <link rel="stylesheet" href="https://use.typekit.net/skj8drm.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <style>
        @import url("https://use.typekit.net/skj8drm.css");
    </style>


</head>
<body>
    @extends('spark::layouts.app')

    @section('content')

        <div class="nav-wrapper">

            <nav class="main-nav">
                <router-link to="/" class="nav-brand tk-reklame-script">Pepper Rodeo</router-link>
                <div class="nav-links">
                    <router-link to="/grocery-lists" class="nav-link active">Grocery Lists</router-link>
                    <router-link to="/recipes" class="nav-link">Recipes</router-link>
                    <a href="/logout" class="nav-link">Log Out</a>
                </div>



            </nav>

            {{--<a href="/logout">Log Out</a>--}}
            {{--<h1 class="nav-brand">xPepper Rodeo</h1>--}}
            {{--<div class="nav-links">--}}
                {{--<router-link to="/grocery-lists" class="nav-link">Grocery Lists</router-link>--}}
                {{--<router-link to="/grocery-lists/create" class="nav-link">Create Grocery List</router-link>--}}
                {{--<router-link to="/recipes" class="nav-link">Recipes</router-link>--}}
                {{--<router-link to="/recipe/create" class="nav-link">Add a Recipe</router-link>--}}

                {{--<a href="/logout">Log Out</a>--}}
                {{--<div class="nav-line"></div>--}}
            {{--</div>--}}
            {{--<router-view name="navigation"></router-view>--}}

        </div>

        <router-view></router-view>
        <device-nav></device-nav>

        <footer>
            <div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
            <div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
            <div>Icons made by <a href="https://www.flaticon.com/authors/gregor-cresnar" title="Gregor Cresnar">Gregor Cresnar</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
        </footer>
    @endsection
</body>

</html>


