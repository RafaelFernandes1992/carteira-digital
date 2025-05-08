@props([
    'items' => [],
    'competenciaId',
    'search'
])

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
    <div class="box-search">
        <form class="box-search"action="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}" 
            method="GET">
            <input type="search" class="form-control" placeholder="Digite um termo para pesquisar"
            name="search" id="search" value="{{ $search }}">

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <a href="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}"
            role="button" class="btn btn-secondary" title="Limpar">
            <i class="bi bi-trash3"></i>
        </a>
    </div>
</div>

<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Cartão</th>
            <th scope="col">Descrição</th>
            <th scope="col">Valor</th>
            <th scope="col">Quantidade Parcelas</th>
            <th scope="col">Valor Parcela</th>
            <th scope="col">Data Compra</th>
            <th scope="col">Data Pagamento Fatura</th>
            <th scope="col">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['nome_cartao'] }}</td>
                <td>{{ $item['descricao'] }}</td>
                <td>{{ $item['valor'] }}</td>
                <td>{{ $item['quantidade_parcelas'] }}</td>
                <td>{{ $item['valor_parcela'] }}</td>
                <td>{{ $item['data_compra'] }}</td>
                <td>{{ $item['data_pagamento_fatura'] }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <a class="btn btn-warning" href="#">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="#" method="POST">
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        @if(count($items) === 0)
            <tr>
                <td colspan="9">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>