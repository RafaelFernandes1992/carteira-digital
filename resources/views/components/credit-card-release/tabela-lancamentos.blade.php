@props([
    'items' => [],
    'competenciaId',
    'search'
])

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-3 mb-3 border-bottom">
    <div class="box-search">
        <form class="box-search" action="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}"
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
            <th>#</th>
            <th>Cartão</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Quantidade Parcelas</th>
            <th>Valor Parcela</th>
            <th>Data Compra</th>
            <th>Data Pagamento Fatura</th>
            <th>Data do Registro</th>
            <th style="text-align: center;">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td style="vertical-align: middle;">{{ $item['id'] }}</td>
                <td style="vertical-align: middle;">{{ $item['nome_cartao'] }}</td>
                <td style="vertical-align: middle;">{{ $item['descricao'] }}</td>
                <td style="vertical-align: middle;">{{ $item['valor'] }}</td>
                <td style="vertical-align: middle;">{{ $item['quantidade_parcelas'] }}</td>
                <td style="vertical-align: middle;">{{ $item['valor_parcela'] }}</td>
                <td style="vertical-align: middle;">{{ $item['data_compra'] }}</td>
                <td style="vertical-align: middle;">{{ $item['data_pagamento_fatura'] }}</td>
                <td style="vertical-align: middle;">{{ $item['created_at'] }}</td>
                <td style="text-align: center;">
                    <div class="d-flex justify-content-center gap-2">
                        <a class="btn btn-warning" href="{{ route('cartao-credito.lancamento.edit', $item['id']) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('cartao-credito.lancamento.destroy', $item['id']) }}" method="POST">
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
        @if(count($items) === 0)
            <tr>
                <td colspan="10">Nenhum registro encontrado.</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>