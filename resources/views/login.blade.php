@extends('layouts.guest')


@session('header')

@endsession

@section('content')
    <div class="container">
        <h2>Login V1 (Assíncrono)</h2>

        <form id="formulario-login">
            <div class="mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
    {{--todos os inputs, precisam ter o atributo html chamado 'name' --}}
                    <input name="email" type="email" class="form-control" id="email">
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input name="password" type="password" class="form-control" id="password">
                </div>
            </div>
            <button id="btn-login" class="btn btn-primary">Sign in</button>
        </form>
    </div>
@endsection
@section('script')
    @vite(['resources/js/auth/login.js'])
@endsection