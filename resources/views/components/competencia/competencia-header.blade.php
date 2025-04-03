@props([
    'saldo_inicial' => 0,
    'saldo_atual' => 0,
    'debitadas_total' => 0,
    'creditadas_total' => 0,
    'nao_debitadas_total' => 0,
    'saldo_atual_previsto' => 0,
    'previsao_debitada' => 0,
])

<div class="row g-3 align-items-end">
    <div class="col-md-2">
        <a href="#">
            <button type="submit" class="btn btn-secondary" name="cancelar" id="cancelar">Cancelar</button>
        </a>
    </div>
    <div class="col-md-2">
        <label class="form-label">Saldo Inicial</label>
        <input type="text" class="form-control" value="{{ $saldo_inicial }}" disabled>
    </div>
    <div class="col-md-2">
        <label class="form-label">Receitas</label>
        <input type="text" class="form-control" value="{{ $creditadas_total }}" disabled>
    </div>
    <div class="col-md-2">
        <label class="form-label">Despesas
            @if($nao_debitadas_total > 0)
                <span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">
                    {{$previsao_debitada}}
                </span>
            @endif
        </label>
        <input type="text" class="form-control" value="{{ $debitadas_total }}" disabled>
    </div>
    <div class="col-md-2">
        <label class="form-label">Investimentos</label>
        <input type="text" class="form-control" value="{{ 0 }}" disabled>
    </div>
    <div class="col-md-2">
        <label class="form-label">Saldo Final
            @if($nao_debitadas_total !== $saldo_atual)
                <span class="badge bg-success-subtle text-success-emphasis rounded-pill">
                    {{$previsao_debitada}}
                </span>
            @endif
        </label>
        <input type="text" class="form-control" value="{{ $saldo_atual }}" disabled>
    </div>

    <label class="form-label">Dízimo calculado: {{ 0 }}</label>
    <form action="" method="POST">
        <a>
            <button type="submit" class="btn btn-success" name="rotineiro" id="rotineiro">Inclui itens rotineiros
            </button>
        </a>
    </form>

</div>