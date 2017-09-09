@extends('spark::layouts.app')

@section('content')
    <div class="main-wrapper">
        <div class="sign-in-section">
            <h1 class="brand">Pepper Rodeo</h1>
            <div class="auth-form">
                @include('spark::shared.errors')
                <form class="form-horizontal" role="form" method="POST" action="/login">
                    {{ csrf_field() }}
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa m-r-xs fa-sign-in"></i>Login
                    </button>

                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                </form>
            </div>

            <span class="line"></span>
        </div>
        <div class="picture-section">

        </div>
    </div>

    <style>
        body {
            width: 100%;
            background: #fff4f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        h2, h3, h4, h5, h6, p, a {
            font-family: 'Roboto', sans-serif;
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
            background: rgba(255,255,255,.8);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            flex-direction: column;
            align-items: center;
        }

        .brand{
            font-family: 'Dancing Script', cursive;
            font-weight: 700;
            font-size: 3em;
            color: #ff4b2e;
        }

        .line {
            width: 100%;
            height: 10px;
            background: #ff4b2e;
            align-self: flex-end;
        }
    </style>

@endsection


