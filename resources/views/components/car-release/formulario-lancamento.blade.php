@props([
    'competenciaId',
    'carros'
])

<br>
<form action="{{ route('competencia.carro.lancamento.store', $competenciaId) }}" method="POST"
      class="row g-3 align-items-end">
    @csrf
    <div class="col-md-2">
        <label for="car_id" class="form-label">Carro
            <span class="text-danger">*</span>
        </label>
        <select class="form-select" aria-label="Default select example" id="car_id" name="car_id" required>
            <option selected value="">Selecione</option>
            @foreach($carros as $carro)
                <option value="{{ $carro->id }}">{{ $carro->getNome() }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="descricao" class="form-label">Descrição
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="text" name="descricao" id="descricao" placeholder="Descreva a despesa">
    </div>

    <div class="col-md-2">
        <label for="valor" class="form-label">Valor
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="number" step="0.01" name="valor" id="valor">
    </div>

    <div class="col-md-2">
        <label for="data_despesa" class="form-label">Data da Despesa
            <span class="text-danger">*</span>
        </label>
        <input class="form-control" type="date" name="data_despesa" id="data_despesa" value="{{ date('Y-m-d') }}">
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-success"><i class="bi bi-floppy"></i> Salvar</button>
    </div>

</form>
