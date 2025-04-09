@extends('layouts.app')


@section('content')
    <h3>Cadastrar Usuário</h3>
    <br>

    <form action="" method="">

        <div class="row">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" id="nome">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input name="email" type="email" class="form-control" id="email">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="senha" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="senha">
            </div>
        </div>

        <div class="row py-4">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </div>

    </form>

@endsection