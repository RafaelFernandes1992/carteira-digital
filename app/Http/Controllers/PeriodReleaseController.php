<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\PeriodRelease;
use App\Http\Requests\StorePeriodReleaseRequest;
use App\Http\Requests\UpdatePeriodReleaseRequest;

class PeriodReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodReleaseRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['user_id'] = auth()->user()->id;
            $model = PeriodRelease::create($dados);

            if ($model->situacao === 'debitado') {
                $period = $model->period;
                $result = $period->saldo_atual - $model->valor_total;

                $period->update(['saldo_atual' => $result]);
            }
            if ($model->situacao === 'creditado') {

            }



            return response()->json([
                'message' => 'Lançamento da Competência criada com sucesso!',
                'data' => $model->with('period:id,saldo_atual')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PeriodRelease $periodRelease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeriodRelease $periodRelease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodReleaseRequest $request, PeriodRelease $periodRelease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeriodRelease $periodRelease)
    {
        //
    }
}
