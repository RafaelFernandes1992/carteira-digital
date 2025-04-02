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
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
