<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0  maximum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jewelers Profit') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/global_custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

    <link rel="icon" sizes="96x96" href="assets/favicon.png"> 

    </head>

    <!-- <body class="{{ (Request::path() ==  'signin' || Request::path() ==  'signup') ? 'splash_view' : ''  }}"> -->

    <body>
    <style>
        #app{
            padding-bottom: 70px;
        }

        .splash_view { width: 100%; height: 100%; background: url(../assets/Jeweler_splash.png) no-repeat; background-size: cover; position: relative;}

.splash_view .my_footer { display: none;}


.splash_view:after { position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; content: ''; background: rgba(0, 0, 0, 0.8);}

.splash_view .container { position: relative; z-index: 2;}

.splash_view #app { padding: 0px !important;}
    </style>
         @if (auth()->user())

        <input type="hidden" id="abc" value="{{session()->get('abc')}}">   

        <script>
           
           var token = document.getElementById('abc').value;

            if(token && token != ''){
                localStorage.setItem('token',token);
            }

        </script>

        @endif

        <div id="app">
            <main-app></main-app>
        </div>

        <?php session()->forget('abc'); ?> 
        <?php session()->save(); ?>

        <?php
            use App\Models\User;
            $user = User::first();
            if(!$user) {
                $srcipt ="localStorage.clear()";
                echo "<script>".$srcipt."</script>";
            }
        ?> 
        <script src="{{ asset('js/app.js') }}"></script>

    </body>

</html>
