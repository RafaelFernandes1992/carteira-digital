@extends('layouts.app')


@section('content')

    <h4>
        <i class="bi bi-person"></i>
        <span>Usuários</span>
    </h4>

    <div class="pt-3 pb-3 mb-3 border-bottom">

    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th style="text-align: begin;">Data do Registro</th>
                <th style="text-align: center;">Deletar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['nome'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['email'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['created_at'] }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">
                            <form action="{{ route('usuario.destroy', $item['id']) }}" method="POST">
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