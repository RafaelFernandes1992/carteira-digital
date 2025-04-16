@extends('layouts.guest')

@section('content')

<div class="login-container">

    <div class="login-title">Cadastrar Usuário</div>

    {{-- Exibe erros de validação --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input name="nome" type="text" class="form-control @error('nome') is-invalid @enderror" placeholder="Digite seu nome" value="{{ old('nome') }}" required>
            @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Digite seu email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite sua senha" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input name="password_confirmation" type="password" class="form-control" placeholder="Confirme sua senha" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>

        <div class="text-center mt-3">
            <p>Já tem uma conta? <a href="{{ route('login.index') }}">Entrar</a></p>
        </div>
    </form>
</div>

@endsection
