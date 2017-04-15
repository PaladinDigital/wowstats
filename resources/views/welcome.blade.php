<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $appName }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #111;
                color: #ececec;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: white;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .intro {
                font-size: 1.2em;
                margin-left: auto;
                margin-right: auto;
                max-width: 80%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/raiding') }}">Raiding</a>
                    <a href="{{ url('/officers') }}">Officers</a>
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <p>{{ $guildName }}<br/><small>Magtheridon EU</small></p>
                </div>
                <div class="intro">
                    <p>A guild for those who like to raid but aren’t interested in elitist dongsnoffler BS. We raid Seriously but Casually meaning we expect our members to take it seriously but we don't scream at each other or guild kick for making a mistake.</p>
                    <p>We keep the membership at 18+ due to the generally adult nature of the humour. Do not join us if you are easily offended but if you like downing current content and dick and fart jokes, this could be the place for you.</p>
                </div>
            </div>
        </div>
    </body>
</html>
