<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-image: url("{{asset('images/main.jpg')}}");
            -moz-background-size: 100% 100%; /* Firefox 3.6*/
            -webkit-background-size: 100% 100%; /* Safari 3.1 Chrome 4.0*/
            -o-background-size: 100% 100%; /* Opera 9.6*/
            background-size: 100% 100%; /* Современные браузеры*/
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
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
            color: #636b6f;
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
        a {
            padding: 5px;
            margin-right: 40px;
            border: 1px solid blue;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                @if(Auth::user()->isDisabled())
                    <strong> <a href="{{ url("/") }}" style="color: #0b3e6f; text-decoration: none">Главная</a></strong>
                @elseif(Auth::user()->isUser())
                    <strong> <a href="{{ url("/user/index") }}" style="color: #0b3e6f; text-decoration: none">Кабинет</a></strong>
                    <strong> <a href="{{ url("/") }}" style="color: #0b3e6f; text-decoration: none">Главная</a></strong>
                @elseif(Auth::user()->isVisitor())
                    <strong> <a href="{{ url("/") }}" style="color: #0b3e6f; text-decoration: none">Главная</a></strong>
                @elseif(Auth::user()->isAdministrator())
                    <strong> <a href="{{ url("/admin/index") }}" style="color: #0b3e6f; text-decoration: none; cursor: pointer">
                            Панель администратора
                        </a>
                    </strong>
                    <strong> <a href="{{ url("/") }}" style="color: #0b3e6f; text-decoration: none">Главная</a></strong>
                @endif

                <strong>
                    <a href="{{ url('logout') }}" class="dropdown-itm" style="color: #0b3e6f; text-decoration: none"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                </strong>

                    <form action="{{ route('logout') }}" id="logout-form" method="POST" style="display: none">
                        @csrf
                    </form>
            @else
                <strong>
                    <a href="{{ route('login') }}" style="color: #0b3e6f; text-decoration: none">Войти</a>
                </strong>

                @if (Route::has('register'))
                    <strong>
                        <a href="{{ route('register') }}" style="color: #0b3e6f; text-decoration: none">Регистрация</a>
                    </strong>
                @endif

            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel admin paneld g
            {{--@php echo WWW @endphp--}}{{--@php echo WWW @endphp--}}
        </div>


        {{--            @php
        $p = \App\SBlog\Core\BlogApp::get_instance()->getProperty('admin_email');
        dd($p);
    @endphp--}}
    </div>
</div>
</body>
</html>
