@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-wallet2"></i>
        <span>Competências da Carteira</span>
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('competencia-carteira.create') }}">
            <button type="button" class="btn btn-secondary" >
                <i class="bi bi-plus-square"></i> Cadastrar
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
                <th>#</th>
                <th>Competência</th>
                <th>Descrição</th>
                <th style="text-align: end;">Saldo Inicial</th>
                <th style="text-align: end;">Saldo Final</th>
                <th style="text-align: end;">Data do Registro</th>
                <th style="text-align: center;">Ações</th>
                <th style="text-align: center;">
                    <span>Lançamentos</span> 
                    <i class="bi bi-wallet2"></i>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="width:05%; vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="width:09%; vertical-align: middle;">{{ $item['competencia'] }}</td>
                    <td style="width:18%; vertical-align: middle;">{{ $item['descricao'] }}</td>
                    <td style="width:9%; text-align: end; vertical-align: middle;">{{ $item['saldo_inicial'] }}</td>
                    <td style="width:9%; text-align: end; vertical-align: middle;">{{ $item['saldo_final'] }}</td>
                    <td style="width:14%; text-align: end; vertical-align: middle;">{{ $item['created_at'] }}</td>

                    <td style="width:9%; text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">
                            <a class="btn btn-warning" href="{{ route('competencia-carteira.edit', $item['id']) }}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('competencia-carteira.destroy', $item['id']) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger" type="submit">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td style="width:10%; text-align: center; vertical-align: middle;">
                        <a class="btn btn-light" href="{{ route('competencia.lancamento.create', $item['id']) }}">
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection