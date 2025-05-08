@extends('layouts.app')


@section('content')

    <h4>Seja bem vindo ao Carteira Digital!</h4>
    <br>

    <div class="box-search">
        <input id="search-input" class="form-control" name="year" type="number" min="1900" max="2099" step="1" placeholder="Ano">
        <button type="submit" class="btn btn-primary">
            <i id="search-graph" class="bi bi-search"></i>
        </button>
    </div>

    <div id="chart">
    </div>

@endsection

@section('script')
    @vite(['resources/js/dashboard/dashboard.js'])
@endsection
