@extends('spark::layouts.app')

@section('content')
    <link rel="stylesheet" href="https://use.typekit.net/skj8drm.css" type='text/css'>

    <div class="login-wrapper">
        <div class="login-box">

            <div class="focused-section">
                <h1 class="brand-login">Pepper Rodeo</h1>
                <div class="login-section">
                    <h3 class="login-message">Welcome Back!</h3>
                    @include('spark::shared.errors')
                    <form class="login-form" role="form" method="POST" action="/login">
                        {{ csrf_field() }}
                        <input type="email" class="auth-input" name="email" placeholder="Email Address" value="{{ old('email') }}" autofocus>
                        <input type="password" class="auth-input" name="password" placeholder="Password">
                        <a class="forgot-pass" href="{{ url('/password/reset') }}">forgot password?</a>

                        <label class="remember-me">
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                        <button name="login_submit" class="login-button">
                            Login
                        </button>


                    </form>

                </div>
            </div>

            <div class="sign-up-teaser">
                <div class="teaser-wrapper">
                    <h3 class="teaser-title">New to Pepper Rodeo?</h3>
                    <p class="teaser-description">Start streamlining your recipes and grocery lists by signing up now.</p>
                    <a href="/register" class="teaser-button">Sign Up</a>
                </div>
            </div>

        </div>
    </div>

@endsection
<style>
    body {
        width: 100%;
        background: #fff4f0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    h2, h3, h4, h5, h6, p, a, input, button {
        font-family: 'Lato', sans-serif;
    }

    .login-wrapper {
        width: 100vw;
        height: 100vh;
        background: hsl(43, 13%, 90%, .4);
        display: grid;
        align-content: center;
        justify-content: center;
    }

    .login-box {
        background: hsl(360, 100%, 100%);
        display: flex;
        width: 60vw;
        max-width: 1000px;
        height: 640px;
        border-bottom: hsl(10, 80%, 58%) 4px solid;
    }
    .brand-login {
        font-family: reklame-script, sans-serif;
        font-weight: 500;
        font-style: normal;
        color: hsl(10, 80%, 58%);
        font-size: 30px;
        align-self: flex-start;
    }

    .focused-section {
        background: hsl(360, 100%, 100%);
        display: flex;
        flex-direction: column;
        width: 70%;
        align-items: center;
        padding: 0 2rem;
    }

    .login-section {
        width: 50%;
        display: flex;
        flex-direction: column;
        margin-top: 7rem;
    }

    .login-message {
        font-size: 20px;
        font-weight: 800;
        color: hsl(11, 80%, 14%);
        width: 100%;
        text-align: center;
    }

    .login-form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .auth-input {
        border: none;
        background: none;
        border-bottom: hsl(10, 80%, 58%) 4px solid;
        margin-top: 20px;
    }

    .auth-input:focus {
        border-bottom: hsl(10, 79%, 42%) 4px solid;
        background: none;
        outline: none;
    }

    .forgot-pass {
        text-align: right;
        color: hsl(41, 8%, 48%);
    }

    .remember-me {
        display: none;
    }

    .login-button {
        background: hsl(10, 80%, 58%);
        border: none;
        border-radius: 4px;
        width: 120px;
        height: 34px;
        color: #ffffff;
        align-self: flex-end;
        margin: 2rem 0;
        font-size: 18px;
    }

    .sign-up-teaser {
        width: 30%;
        background: url("/img/login-background-2.png");
        opacity: .8;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        display: flex;
        flex-direction: column;
        padding: 1rem;
        align-items: center;
        align-content: center;
        /*justify-content: center;*/
    }

    .teaser-wrapper {
        margin-top: 15rem;
        color: hsl(40, 23%, 97%);
        display: grid;
        justify-items: center;
        align-items: center;
        z-index: 12;
    }

    .teaser-title {
        font-size: 20px;
        font-weight: 800;
        text-align: center;
    }

    .teaser-description {
        font-size: 14px;
        width: 70%;
    }

    .teaser-button {
        border: 4px solid hsl(40, 23%, 97%);
        border-radius: 4px;
        padding: 7px 70px;
        color: hsl(40, 23%, 97%);
        font-size: 18px;
    }
</style>
