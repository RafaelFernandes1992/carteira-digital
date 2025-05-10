@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-credit-card-2-back"></i> 
        <span>Cartões de Crédito</span>
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('cartao-credito.create') }}">
            <button type="button" class="btn btn-secondary">
                <i class="bi bi-plus-square"></i> Cadastrar
            </button>
        </a>
        <div class="box-search">
            <input type="search" class="form-control" placeholder="Digite um termo para pesquisar" id="pesquisar">
            <button class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col" style="text-align: begin;">#</th>
                <th scope="col" style="text-align: begin;">Número</th>
                <th scope="col" style="text-align: begin;">Apelido</th>
                <th scope="col" style="text-align: begin;">Limite Crédito</th>
                <th scope="col" style="text-align: begin;">Dia Vencimento</th>
                <th scope="col" style="text-align: begin;">Dia Fechamento</th>
                <th scope="col" style="text-align: begin;">Data do Registro</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itensCreditCard as $item)
                <tr>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['numero_cartao'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['apelido'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['valor_limite'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['dia_vencimento_fatura'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['dia_fechamento_fatura'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['created_at'] }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">
                            <a class="btn btn-warning" href="{{ route('cartao-credito.edit', $item['id']) }}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('cartao-credito.destroy', $item['id']) }}" method="POST">
                                @method('DELETE')
                                @csrf
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