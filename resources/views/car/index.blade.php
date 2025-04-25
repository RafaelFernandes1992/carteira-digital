@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-car-front"></i>
        <span>Carros</span> 
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('carro.create') }}">
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
                <th scope="col" style="text-align: begin;">Descrição</th>
                <th scope="col" style="text-align: begin;">Rotineira</th>
                <th scope="col" style="text-align: begin;">Dedutível</th>
                <th scope="col" style="text-align: begin;">Isenta</th>
                <th scope="col" style="text-align: begin;">Tipo</th>
                <th scope="col" style="text-align: center;">Data do registro</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
            </thead>
            <tbody>
            
                <tr>
                    <td style="width:05%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width:18%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width: 8%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width:12%; text-align: begin; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width: 9%; text-align: center; vertical-align: middle;">{{ 0 }}</td>
                    <td style="width:14%; text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">
                            <a class="btn btn-warning" href="#">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('carro.destroy', 0) }}" method="POST">
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

@endsection