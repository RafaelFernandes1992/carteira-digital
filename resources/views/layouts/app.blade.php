<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name') }}</title>
        @yield('header')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        @yield('body')
        <x-navbar-header />
        <div class="container-fluid">
            <div class="row">
                <x-side-bar/>
                <main class="col-sm-8 col-md-9 col-lg-10 ms-sm-auto py-4 px-5">
                    @if(session('message'))
                        {{--        <div class="alert alert-success">--}}
                        {{--            {{ session('message') }}--}}
                        {{--        </div>--}}
                        <div class="toast text-bg-success show align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('message') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    </body>

</html>