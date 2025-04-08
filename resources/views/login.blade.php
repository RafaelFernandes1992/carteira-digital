@extends('layouts.guest')

@section('content')

<div class="login-container">
    <div class="login-title">Carteira Digital</div>
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    <form action="{{ route('index.login') }}" method="POST">

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

      <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
  </div>


@endsection
