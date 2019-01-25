@extends('spark::layouts.app')

@section('content')
    <link rel="stylesheet" href="https://use.typekit.net/skj8drm.css" type='text/css'>

    <div class="login-wrapper">
        <div class="login-box">

            <div class="focused-section" id="login-section">
                <h1 class="brand-login">Pepper Rodeo</h1>
                <div class="login-section" id="mobile-login-section">
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
                    <a class="signup-link" onclick="showMobileRegister()" id="signup-link">Create an Account</a>
                </div>
            </div>

            <div class="sign-up-teaser" id="sign-up-teaser">
                <div class="teaser-wrapper">
                    <h3 class="teaser-title">New to Pepper Rodeo?</h3>
                    <p class="teaser-description">Start streamlining your recipes and grocery lists by signing up now.</p>
                    <a class="teaser-button" onclick="showRegister()">Sign Up</a>
                </div>
            </div>

            <div class="login-teaser" id="login-teaser-section">
                <div>
                    <h3 class="brand-register">Pepper Rodeo</h3>
                    <div class="teaser-wrapper">
                        <h3 class="teaser-title">Already have an account?</h3>
                        <p class="teaser-description">Access your wonderfully organized recipes and lists below.</p>
                        <a class="teaser-button" onclick="showLogin()">Login</a>
                    </div>
                </div>
            </div>

            <div class="register-section register-hidden" id="register-section">
                <div class="register-wrapper">
                    <h3 class="register-title">Create an Account</h3>
                    <input type="email" class="register-auth-input" name="register-email" placeholder="Email Address" autofocus>
                    <input type="password" class="register-auth-input" name="register-password" placeholder="Password">
                    <input type="password" class="register-auth-input" name="register-password" placeholder="Confirm Password">
                    <button name="register-submit" class="register-button">
                        Sign Up
                    </button>
                    <a class="mobile-account-link" id="mobile-account-link" onclick="showMobileLogin()">Already have an account?</a>
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
        border-radius: 4px;
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
        order: 1;
        flex: 2;
    }

    .login-section {
        width: 50%;
        display: flex;
        flex-direction: column;
        margin-top: 9rem;
        order: 2;
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
        transition: all .2s ease-in-out;
    }

    .auth-input:hover {
        border-bottom: hsl(10, 79%, 42%) 4px solid;
    }

    .auth-input:focus {
        border-bottom: hsl(10, 79%, 42%) 4px solid;
        background: none;
        outline: none;
    }

    .forgot-pass {
        text-align: right;
        color: hsl(41, 8%, 48%);
        transition: all .2s ease-in-out;
    }

    .forgot-pass:hover {
        cursor: pointer;
        color: hsl(10, 79%, 42%);
        text-decoration: none;
        font-weight: 500;
    }

    .remember-me {
        display: none;
    }

    .sm-screen {
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
        transform: translateX(0px);
        transition: all .2s ease-in-out;
    }

    .login-button:hover {
        background: hsl(10, 79%, 42%);
        transform: translateX(4px);
        transition: all .2s ease-in-out;
    }

    .sign-up-teaser {
        width: 30%;
        background: url("/img/login-background-2.png");
        opacity: 1;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        display: flex;
        flex-direction: column;
        padding: 1rem;
        align-items: center;
        align-content: center;
        order: 2;
        margin-right: -2rem; /*shame!*/
        transition: transform .3s ease-out;
        transform: translateX(0px);
    }

    .signup-teaser-hidden {
        width: 0;
        order: 1;
        z-index: -2;
        opacity: 0;
        transform: translateX(-700px);
        transition: transform .3s ease-out;
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
        /*border: 4px solid hsl(40, 23%, 97%);*/
        border-radius: 4px;
        padding: 7px 70px;
        color: hsl(40, 23%, 97%);
        font-size: 18px;
        box-shadow: inset 0 0 0 4px hsl(40, 23%, 97%), 0 0 1px transparent;
        transition: all .3s ease-in-out;
    }

    .teaser-button:hover {
        color: hsl(10, 80%, 58%);
        font-weight: 500;
        background: hsl(10, 79%, 94%);
        cursor: pointer;
        text-decoration: none;
        box-shadow: inset 0 0 0 4px hsl(10, 80%, 58%), 0 0 1px transparent;
    }

    .login-teaser {
        background: url("/img/login-background-2.png");
        opacity: 1;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        display: flex;
        flex-direction: column;
        padding: 1rem;
        align-items: center;
        align-content: center;
        transform: translateX(700px);
        width: 0;
        order: 2;
        z-index: -1;
    }

    .login-teaser-display {
        opacity: 1;
        transform: translateX(0);
        width: 30%;
        transition: transform .3s ease-out;
        z-index: 1;
        order: 1;
        margin-left: -4rem;
    }

    .brand-register {
        font-family: reklame-script, sans-serif;
        font-weight: 500;
        font-style: normal;
        color: #ffffff;
        font-size: 30px;
        align-self: flex-start;
    }

    .login-teaser .teaser-wrapper {
        margin-top: 9rem;
    }
    .signup-link {
        opacity: 0;
    }

    .register-section {
        background: hsl(360, 100%, 100%);
        display: flex;
        flex-direction: column;
        width: 70%;
        align-items: center;
        padding: 0 2rem;
        order: 2;
    }

    .register-hidden {
        display: none;
    }

    .register-wrapper {
        width: 50%;
        display: flex;
        flex-direction: column;
        margin-top: 15rem;
    }

    .register-title {
        font-size: 20px;
        font-weight: 800;
        color: hsl(11, 80%, 14%);
        width: 100%;
        text-align: center;
    }

    .register-auth-input {
        border: none;
        background: none;
        border-bottom: hsl(10, 80%, 58%) 4px solid;
        margin-top: 20px;
    }

    .register-auth-input:focus {
        border-bottom: hsl(10, 79%, 42%) 4px solid;
        background: none;
        outline: none;
    }

    .register-auth-input:hover {
        border-bottom: hsl(10, 79%, 42%) 4px solid;
    }

    .register-button {
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

    .register-button:hover {
        background: hsl(10, 79%, 42%);
        transform: translateX(4px);
        transition: all .2s ease-in-out;
    }

    .mobile-account-link {
        opacity: 0;
    }

    @media (max-width: 1300px) {
        .login-box {
            width: 80vw;
        }

    }

    @media (max-width: 900px) {
        .login-box {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sign-up-teaser {
            display: none;

        }

        .focused-section {
            width: 100%;
        }

        .focused-section-register {
            height: 20%;
        }

        .brand-login {
            align-self: center;
            font-size: 48px;
            margin-top: 6rem;
        }

        .login-section {
            margin-top: 0;
            width: 70%;
        }

        .login-button {
            width: 100%;
            height: 36px;
            margin: 1rem 0;
        }

        .login-teaser {
            display: none;
        }

        .sm-screen {
            display: block;
        }

        .signup-link {
        opacity: 1;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: hsl(10, 79%, 23%);
        }

        .signup-link:hover, .signup-link:focus {
            color: hsl(10, 79%, 42%);
            text-decoration: none;
            cursor: pointer;
        }

        .register-section {
            width: 80vw;
            height: 0;
            background: url("/img/login-background-2.png");
            transform: translateY(900px);
            transition: all .2s ease-in-out;
            border-radius: 4px;
        }

        .register-hidden {
            display: flex;
        }

        .mobile-register-transition {
            height: 80%;
            transform: translateY(0px);
            transition: all .5s ease-in-out;
        }

        .register-wrapper {
            width: 80%;
            margin-top: 0;
        }

        .register-title {
         color: hsl(40, 23%, 97%);
        }

        .register-auth-input {
            border-bottom: hsl(10, 79%, 94%) 4px solid;
        }

        .register-auth-input::placeholder {
            color: hsl(10, 79%, 94%);
            font-weight: 500;
        }

        .register-button {
            width: 100%;
            background: #ffffff;
            color: hsl(10, 79%, 42%);
            font-weight: 500;
        }

        .register-button:hover {
            color: hsl(10, 79%, 94%);
        }

        .mobile-account-link {
            opacity: 1;
            color: hsl(10, 79%, 94%);
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .mobile-account-link:hover {
            cursor: pointer;
            color: #ffffff;
            text-decoration: none;
        }

    }


</style>
<script>
    function showRegister() {
        let register = document.getElementById("register-section");
        register.classList.remove("register-hidden");

        let loginTeaser = document.getElementById("login-teaser-section");
        loginTeaser.classList.add("login-teaser-display");

        let login = document.getElementById("login-section");
        login.classList.add("signup-teaser-hidden");

        let signupTeaser = document.getElementById("sign-up-teaser");
        signupTeaser.classList.add("signup-teaser-hidden");
    }
    function showLogin() {
        let register = document.getElementById("register-section");
        register.classList.add("register-hidden");

        let loginTeaser = document.getElementById("login-teaser-section");
        loginTeaser.classList.remove("login-teaser-display");

        let login = document.getElementById("login-section");
        login.classList.remove("signup-teaser-hidden");

        let signupTeaser = document.getElementById("sign-up-teaser");
        signupTeaser.classList.remove("signup-teaser-hidden");
    }

    function showMobileRegister() {
        let register = document.getElementById("register-section");
        register.classList.add('mobile-register-transition');

        let login = document.getElementById("mobile-login-section");
        login.classList.add("hidden");

        let accountLink = document.getElementById("mobile-account-link");
        accountLink.classList.remove("hidden");

        let focused = document.getElementById("login-section");
        focused.classList.add('focused-section-register');

    }

    function showMobileLogin() {
        let register = document.getElementById("register-section");
        register.classList.remove('mobile-register-transition');

        let login = document.getElementById("mobile-login-section");
        login.classList.remove("hidden");

        let accountLink = document.getElementById("mobile-account-link");
        accountLink.classList.add("hidden");

        let focused = document.getElementById("login-section");
        focused.classList.remove('focused-section-register');

    }

</script>
<script>
    import LoginAndRegister from "../../../../assets/js/components/LoginAndRegister";
    export default {
        components: {LoginAndRegister}
    }
</script>
