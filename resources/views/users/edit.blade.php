@extends('layouts.app')

@section('content')
    <h4><i class="bi bi-person"></i> Meu Perfil</h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3">
        <a class="btn btn-secondary" href="{{ route('inicio') }}">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <form action="{{ route('usuario.perfil.update') }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" value="{{ old('nome', $user->nome) }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Nova Senha <small class="text-muted">(Deixe em branco se não quiser alterar)</small></label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="col-md-6">
            <label class="form-label">Confirmação da Nova Senha</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-floppy"></i> Salvar
            </button>
        </div>
    </form>
@endsection
