<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\PeriodRelease;
use Carbon\Carbon;

class AlertController extends Controller
{

    public function alertasDespesas()
    {
        $user = Auth::user();
        $alertas = PeriodRelease::with('typeRelease','period')
        ->where('user_id', $user->id)
        ->where('situacao', 'nao_debitado')
        ->orderBy('data_debito_credito', 'asc')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'competencia' => $item->period ? $item->period->getNomeCompetencia() : 'Competência não informada',
                'descricao' => $item->typeRelease->descricao ?? 'Tipo não informado',
                'valor_total' => number_format($item->valor_total, 2, ',', '.'),
                'data_debito_credito' => \Carbon\Carbon::parse($item->data_debito_credito)->format('d/m/Y'),
                'observacao' => $item->observacao ?? '---',
                'situacao' => $item->getSituacaoFormatada(),
                'updated_at' => \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y H:i'),
            ];
        })
        ->groupBy('competencia');;
        return view('alert-notification.index')->with(['alertas' => $alertas]);
    }   

    public function marcarComoPago($id)
    {
        $user = Auth::user();
        $release = PeriodRelease::findOrFail($id);
        if ($release->user_id !== $user->id) {
            abort(403);
        }
        $release->update(['situacao' => 'debitado']);

        return redirect()->route('alerta-notificacao.index')->with('message', 'Despesa alterada para debitada!');
    }
   
}