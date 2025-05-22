@props([
    'items' => [],
    'total_despesas_carro' => 0,
    'total_despesas_cartao_credito' => 0,
])
<br>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Tipo</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Situação</th>
            <th>Data</th>
            <th>Observação</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                @php
                    $classeLinha = $item['situacao'] === 'Não Debitado' ? 'table-warning fw-bold' : '';
                    switch ($item['situacao']) {
                        case 'Não Debitado':
                            $classeBadge = 'bg-danger text-white';
                            break;
                        case 'Debitado':
                            $classeBadge = 'bg-success text-white';
                            break;
                        default:
                            $classeBadge = 'bg-info text-white';
                            break;
                    }
                @endphp
                <tr class="{{ $classeLinha }}">
                    <td style="vertical-align: middle;">{{ $item['type_release']['tipo'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['type_release']['descricao'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['valor_total'] }}</td>
                    <td style="vertical-align: middle;">
                        <span class="badge {{ $classeBadge }} ">{{ $item['situacao'] }}</span>
                    </td>
                    <td style="vertical-align: middle;">{{ $item['data_debito_credito'] }}</td>
                    <td style="vertical-align: middle;">{{ $item['observacao'] }}</td>
                    <td style="vertical-align: middle;">
                        <div class="d-flex gap-2">
                            <a class="btn btn-warning" href="{{ route('competencia.lancamento.edit', $item['id']) }}">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('competencia.lancamento.destroy', $item['id']) }}" method="POST">
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

            <tr>
                <td style="vertical-align: middle;">Despesa</td>
                <td style="vertical-align: middle;">Lançamentos do Carro</td>
                <td style="vertical-align: middle;">{{ $total_despesas_carro }}</td>
                <td style="vertical-align: middle;"></td>
                <td style="vertical-align: middle;"></td>                
                <td style="vertical-align: middle;"></td>
                <td style="vertical-align: middle;">
                    <a class="btn btn-light" 
                    href="{{ route('competencia.carro.lancamento.create', $competenciaId) }}">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle;">Despesa</td>
                <td style="vertical-align: middle;">Lançamentos do Cartão de Crédito</td>
                <td style="vertical-align: middle;">{{ $total_despesas_cartao_credito }}</td>
                <td style="vertical-align: middle;"></td>
                <td style="vertical-align: middle;"></td>                
                <td style="vertical-align: middle;"></td>

                <td style="vertical-align: middle;">
                    <a class="btn btn-light" 
                    href="{{ route('competencia.cartao-credito.lancamento.create', $competenciaId) }}">
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                </td>
            </tr>
        @if(count($items) === 0)
            <!-- <tr>
                <td colspan="7">Nenhum registro encontrado.</td>
            </tr> -->
        @endif
        </tbody>
    </table>


</div>