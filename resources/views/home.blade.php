@extends('layouts.app')


@section('content')

    
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ano <span id="dashboard-year">{{ date('Y') }}</span></h4>

            <div class="box-search-charts">
                <input id="search-input" class="form-control" name="year" type="number" min="2000" max="2099" step="1"
                    value="{{ date('Y') }}">
                <button class="btn btn-primary" id="btn-search">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div class="row pt-4 g-3">
            
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-calendar3 card-icon text-blue"></i>
                        <div>
                            <h5 class="card-title">Competências</h5>
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
                            <h5 class="card-title">Receitas</h5>
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
                            <h5 class="card-title">Despesas</h5>
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
                            <h5 class="card-title">Investimentos</h5>
                            <p class="card-text fs-5 fw-bold" id="total_investimentos">Carregando...</p>
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
