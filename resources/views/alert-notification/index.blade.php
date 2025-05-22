@extends('layouts.app')

@section('content')

<h4><i class="bi bi-bell"></i> Alertas e Notificações</h4>

@if($alertas->isEmpty())

    <div class="pt-3">
        <div class="alert alert-light">
            <i class="bi bi-stars text-warning"></i> 
            <span class="text-success fw-bold" >Parabéns! Todas as suas despesas e investimentos estão em dia.</span>
        </div>
    </div>

@else
        <div class="pt-3">
            <div class="alert alert-light">
                <i class="bi bi-exclamation-triangle-fill text-warning"></i> 
                <span class="text-danger fw-bold">Você possui despesas e/ou investimentos com situação "Não Debitado". 
                    Verificar e atualizar.</span>
            </div>
        </div>

    @foreach($alertas as $competencia => $itens)

        <h5 class="mt-4">Competência: {{ $competencia }}</h5>
        <div class="row row-cols-1 row-cols-md-1 g-3">
            @foreach($itens as $item)
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-warning fw-bold d-flex justify-content-between">
                            {{ $item['descricao'] }} R$ {{ $item['valor_total'] }}
                            <span class="badge bg-danger">{{ $item['situacao'] }}</span>
                        </div>
                        <div class="card-body">
                            <p class="small">Tipo: {{ $item['tipo'] }}</p>
                            <p class="small">Data Prevista: {{ $item['data_debito_credito'] }}</p>
                            <p class="small">Observação: {{ $item['observacao'] }}</p>
                            <p class="small">Última atualização: {{ $item['updated_at'] }}</p>
                        </div>

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a class="btn btn-outline-warning" href="{{ route('competencia.lancamento.edit', $item['id']) }}">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form method="POST" action="{{ route('alerta-notificacao.marcarComoPago', $item['id']) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-success">
                                        <i class="bi bi-check2-circle"></i> Alterar para Debitado
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
    
@endif

@endsection