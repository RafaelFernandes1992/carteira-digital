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
        <div class="container-fluid">
            <div class="row">
                <x-side-bar/>
                <main class="col-sm-8 col-md-9 col-lg-10 ms-sm-auto py-4 px-5">

                    @if(session('message'))
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                            <div class="toast text-bg-success show align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <p>{{ session('message') }}</p>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('messageWarning'))
                        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                            <div class="toast text-bg-warning show align-items-center text-white" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <p>{{ session('messageWarning') }}</p>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050;">
                        @if ($errors->any())
                            <div class="toast text-bg-danger show align-items-center mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
                                </div>
                            </div>
                        @endif

                        @if(session('error') || session('validation_errors'))
                            <div class="toast text-bg-danger show align-items-center mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <!-- Exibe a mensagem de erro, se houver -->
                                        @if(session('error'))
                                            <p>{{ session('error') }}</p>
                                        @endif

                                        <!-- Exibe os erros de validação, se houver -->
                                        @if(session('validation_errors'))
                                            <ul>
                                                @foreach(session('validation_errors')->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @yield('content')
                    
                </main>
            </div>
        </div>
        @yield('script')
    </body>

</html>