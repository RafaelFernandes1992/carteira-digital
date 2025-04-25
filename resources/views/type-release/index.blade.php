@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-currency-dollar"></i>
        <span>Tipos de Lançamento</span> 
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('tipo-lancamento.create') }}">
            <button type="button" class="btn btn-secondary" title="Incluir">
                <i class="bi bi-plus-square"></i>
                <span>Novo</span>
            </button>
        </a>
        <div class="box-search">
            <input type="search" class="form-control" placeholder="Digite um termo para pesquisar" id="pesquisar">
            <button onclick="" class="btn btn-primary" title="Pesquisar">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col" style="text-align: begin;">#</th>
                <th scope="col" style="text-align: begin;">Tipo</th>
                <th scope="col" style="text-align: begin;">Descrição</th>
                <th scope="col" style="text-align: begin;">Rotineira</th>
                <th scope="col" style="text-align: begin;">Isenta</th>
                <th scope="col" style="text-align: begin;">Dedutível</th>
                <th scope="col" style="text-align: center;">Data do registro</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itens as $item)
                <tr>
                    <td style="width:05%; text-align: begin; vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="width:5%; text-align: begin; vertical-align: middle;">{{ $item['tipo'] }}</td>
                    <td style="width:18%; text-align: begin; vertical-align: middle;">{{ $item['descricao'] }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ $item['rotineira'] }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ $item['isenta'] }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ $item['dedutivel'] }}</td>
                    <td style="width: 9%; text-align: center; vertical-align: middle;">{{ $item['created_at'] }}</td>
                    <td style="width:14%; text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">

                            <a class="btn btn-warning" href="{{ route('tipo-lancamento.edit', $item['id']) }}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('tipo-lancamento.destroy', $item['id']) }}" method="POST">
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection