@extends('layouts.guest')


@session('header')

@endsession

@section('content')

{{--todos os inputs, precisam ter o atributo html chamado 'name' --}}
<div class="login-container">
    <div class="login-title">Carteira Digital (Assíncrono)</div>

    <form id="formulario-login">

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu email" required>
      </div>

      <div class="mb-3">
        <label for="senha" class="form-label">Senha</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
      </div>

      <button id="btn-login" class="btn btn-primary w-100">Entrar</button>
    </form>
  </div>


@endsection
@section('script')
    @vite(['resources/js/auth/login.js'])
@endsection