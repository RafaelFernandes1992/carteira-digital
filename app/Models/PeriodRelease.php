<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeriodRelease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'valor_total',
        'observacao',
        'data_debito_credito',
        'situacao',
        'user_id',
        'period_id',
        'type_release_id',
    ];

    public const SITUACAO = [
      'debitado' => 'Debitado',
      'creditado' => 'Creditado',
      'nao_debitado' => 'Não Debitado'
    ];

    public function getSituacaoFormatada(): string
    {
        return self::SITUACAO[$this->situacao];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function typeRelease(): BelongsTo
    {
        return $this->belongsTo(TypeRelease::class);
    }

}
