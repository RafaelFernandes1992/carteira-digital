@props([
    'saldo_inicial' => 0,
    'total_investimentos' => 0,
    'total_despesas' => 0,
    'total_receitas' => 0,
    'saldo_final' => 0,
    'dizimo_calculado' => 0,
])

<div class="row g-3 align-items-end">

    <div class="col-md-2">
        <label class="form-label">Dízimo calculado</label>
        <input type="text" class="form-control" value="{{ $dizimo_calculado }}" disabled>
    </div>

    <div class="col-md-2">
        <label class="form-label">Saldo Inicial</label>
        <input type="text" class="form-control" value="{{ $saldo_inicial }}" disabled>
    </div>

    <div class="col-md-2">
        <label class="form-label">Receitas</label>
        <input type="text" class="form-control" value="{{ $total_receitas }}" disabled>
    </div>

    <div class="col-md-2">
        <label class="form-label">Despesas</label>
        <input type="text" class="form-control" value="{{ $total_despesas }}" disabled>
    </div>

    <div class="col-md-2">
        <label class="form-label">Investimentos</label>
        <input type="text" class="form-control" value="{{ $total_investimentos }}" disabled>
    </div>

    <div class="col-md-2">
        <label class="form-label">Saldo Final</label>
        <input type="text" class="form-control" value="{{ $saldo_final }}" disabled>
    </div>

</div>