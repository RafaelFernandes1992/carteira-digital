@extends('layouts.app')


@section('content')

    <h4>
        <i class="bi bi-person"></i>
        <span>Usuários</span>
    </h4>

    <div class="pt-3 pb-3 mb-3 border-bottom">
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
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col" style="text-align: center;">Data registro</th>
                <th scope="col" style="text-align: center;">Deletar</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $item)
                <tr>
                    <td style="width:05%; vertical-align: middle;">{{ $item['id'] }}</td>
                    <td style="width:09%; vertical-align: middle;">{{ $item['nome'] }}</td>
                    <td style="width:18%; vertical-align: middle;">{{ $item['email'] }}</td>
                    <td style="width:14%; text-align: center; vertical-align: middle;">{{ $item['created_at'] }}</td>
                    <td style="width:9%; text-align: center; vertical-align: middle;">
                        <div class="d-flex justify-content-center gap-2">
                            <form action="#" method="POST">
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