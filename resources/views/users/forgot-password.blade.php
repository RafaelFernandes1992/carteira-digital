@extends('layouts.guest')

@section('content')

<div class="login-container">
    <div class="login-title">Esqueceu sua Senha?</div>

    {{-- Exibe mensagens de sucesso e erro --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('senha.email') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Digite seu e-mail</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Digite seu e-mail" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Enviar Link</button>

        <div class="text-center mt-3">
            <p>Lembrou a senha? <a href="{{ route('login.index') }}">Voltar para login</a></p>
        </div>
    </form>
</div>

@endsection