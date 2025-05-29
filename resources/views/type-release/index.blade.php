@extends('layouts.app')

@section('content')

    <h4>
        <i class="bi bi-currency-dollar"></i>
        <span>Tipos de Lançamento</span> 
    </h4>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
        <a href="{{ route('tipo-lancamento.create') }}" class="btn btn-secondary">
            <i class="bi bi-plus-square"></i> Cadastrar
        </a>
        <div class="box-search">
            <form class="box-search" action="{{ route('tipo-lancamento.index') }}"
                method="GET">
                <input type="search" class="form-control" placeholder="Digite um termo para pesquisar"
                name="search" id="search" value="{{ $search }}">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <a href="{{ route('tipo-lancamento.index') }}"
                role="button" class="btn btn-secondary" title="Limpar">
                <i class="bi bi-trash3"></i>
            </a>
        </div>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col" style="text-align: begin;">#</th>
                <th scope="col" style="text-align: begin;">Tipo</th>
                <th scope="col" style="text-align: begin;">Descrição</th>
                <th scope="col" style="text-align: begin;">Rotineiro</th>
                <th scope="col" style="text-align: begin;">Isento</th>
                <th scope="col" style="text-align: begin;">Dedutível</th>
                <th scope="col" style="text-align: begin;">Data do Registro</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itens as $item)
                <tr>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['tipo'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['descricao'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['rotineira'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['isenta'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['dedutivel'] }}</td>
                    <td style="text-align: begin; vertical-align: middle;">{{ $item['created_at'] }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">

                            <a class="btn btn-warning" href="{{ route('tipo-lancamento.edit', $item['id']) }}">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ route('tipo-lancamento.destroy', $item['id']) }}" method="POST">
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

    <div class="d-flex justify-content-between align-items-center mt-3">

        {{-- Informação de registros --}}
        <div class="text-muted pt-0 pb-4">
            Mostrando de {{ $itens->firstItem() ?? 0 }} até {{ $itens->lastItem() ?? 0 }} de {{ $itens->total() }} registros
        </div>

        {{-- Navegação da paginação --}}
        <div>
            {{ $itens->appends(['search' => $search])->links() }}
        </div>

    </div>


@endsection