<!doctype html>
<html lang="en">
@php
    $authUser = Auth::user();
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        @isset($pageTitle)
            {{ $pageTitle }} |
        @endisset {{ env('APP_NAME') }}
    </title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <link href="{{ asset('/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/pe7-icons.css') }}" rel="stylesheet">

    <style>
        #preloader {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0px;
            background: rgba(20, 20, 20, 0.3);
            z-index: 100;   
            display: none;
            align-items: center;
            justify-content: center
        }


        .lds-ripple {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ripple div {
            position: absolute;
            border: 4px solid #fff;
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        .lds-ripple div:nth-child(2) {
            animation-delay: -0.5s;
        }

        @keyframes lds-ripple {
            0% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 0;
            }

            4.9% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 0;
            }

            5% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 1;
            }

            100% {
                top: 0px;
                left: 0px;
                width: 72px;
                height: 72px;
                opacity: 0;
            }
        }
    </style>
</head>


<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">

        @include('includes.header')

        {{--@include('includes.theme-options')--}}

        <div class="app-main">
            @include('includes.sidebar')


            <div class="app-main__outer">

                <div class="mt-4 px-md-4 px-1">
                    {{-- MAIN CONTENT HERE --}}
                    @yield('content')
                </div>

                @include('includes.footer')
            </div>


            <div id="preloader">
                <div class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
            </div>

</body>

</html>
