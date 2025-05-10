@extends('layouts.guest')

@section('content')

<div class="login-container">
    <div class="login-title">Carteira Digital</div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif



    <form action="{{ route('login.index') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>     
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Digite seu email" value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite sua senha">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>


        {{-- Lembrar-me e Esqueceu senha --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>
            <a href="{{ route('senha.request') }}">Esqueceu a senha?</a>
        </div>


        <button type="submit" class="btn btn-primary w-100">Entrar</button>

        <div class="text-center mt-3">
            <p>É novo aqui? <a href="{{ route('users.create') }}">Cadastre-se</a></p>
        </div>
    </form>
  </div>


@endsection
