@extends('layouts.app')


@section('content')

    <h4>Seja bem vindo(a)!</h4>
    <br>

    <div class="mt-5">
        <div class="d-flex justify-content-between">
            <h3 class="mb-4">Ano <span id="dashboard-year">{{ date('Y') }}</span></h3>
            <div class="box-search-charts">
                <input id="search-input" class="form-control" name="year" type="number" min="1900" max="2099" step="1"
                       value="{{ date('Y') }}">
                <button class="btn btn-primary" id="btn-search">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
        <div class="row mt-2 g-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-calendar3 card-icon text-blue"></i>
                        <div>
                            <h5 class="card-title">Competências do Ano</h5>
                            <p class="card-text fs-5 fw-bold" id="total_competencias">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-cash-stack card-icon text-green"></i>
                        <div>
                            <h5 class="card-title">Receitas do Ano</h5>
                            <p class="card-text fs-5 fw-bold" id="total_receitas">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-currency-exchange card-icon text-red"></i>
                        <div>
                            <h5 class="card-title">Despesas do Ano</h5>
                            <p class="card-text fs-5 fw-bold" id="total_despesas">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-graph-up card-icon text-purple"></i>
                        <div>
                            <h5 class="card-title">Investimentos do Ano</h5>
                            <p class="card-text fs-5 fw-bold" id="total_investimentos">Carregando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="chart">
    </div>

@endsection

@section('script')
    @vite(['resources/js/dashboard/dashboard.js'])
@endsection
