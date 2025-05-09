@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-car-front"></i>
        <span>Carros</span> 
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('carro.create') }}">
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
                <th style="text-align: begin;">#</th>
                <th style="text-align: begin;">Apelido</th>
                <th style="text-align: begin;">Renavam</th>
                <th style="text-align: begin;">Placa</th>
                <th style="text-align: begin;">Marca</th>
                <th style="text-align: begin;">Modelo</th>
                <th style="text-align: begin;">Data da aquisição</th>
                <th style="text-align: center;">Data do registro</th>
                <th style="text-align: center;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itensCar as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['apelido'] }}</td>
                    <td>{{ $item['renavam'] }}</td>
                    <td>{{ $item['placa'] }}</td>
                    <td>{{ $item['marca'] }}</td>
                    <td>{{ $item['modelo'] }}</td>
                    <td>{{ $item['data_aquisicao'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a class="btn btn-warning" href="#">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('carro.destroy', $item['id']) }}" method="POST">
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