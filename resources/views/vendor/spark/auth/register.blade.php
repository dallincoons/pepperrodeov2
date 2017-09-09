@if (Spark::billsUsingStripe())
    @include('spark::auth.register-stripe')
@else
    @include('spark::auth.register-braintree')
@endif
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
    #spark-app {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .main-wrapper {
        display: flex;
        width: 60%;
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

    .sign-in-form {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 35%;
    }

    .brand{
        font-family: 'Dancing Script', cursive;
        font-weight: 700;
        font-size: 3em;
        color: #ff4b2e;
    }

    .auth-input {
        border: 1px solid #a6a6a6;
        border-radius: 0;
        font-size:1.5em;
        margin: 5% 0;
        padding-left: 1%;
    }

    .forgot-pass {
        color: #ff4b2e;
        display: block;
        align-self: flex-end;
        margin: -4% 0 25% 0;
    }

    .forgot-pass:hover {
        color: #ff4b2e;
        text-decoration: none;
    }

    .pr-button {
        width: 100%;
        background: #ff4b2e;
        font-size:1.5em;
        color: #FFFFFF;
        border: none;
        margin-bottom: 50%;
        transition: background 3s;
    }

    .pr-button:hover {
        background: #BF3822;
        transition: background 3s;
    }

    .remember-me {
        color: #ff4b2e;
        text-align: left;
        margin-bottom: 0;
        display: block;
    }


    .register-link {
        align-self: flex-end;
        text-align: right;
        color: #ff4b2e;
        font-weight: 700;
        padding-right: 3%;
        transition: color 2s;
        position: absolute;
        bottom: 10;
    }

    .register-link:hover {
        cursor: pointer;
        color: #BF3822;
        transition: color 2s;
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
</style>
