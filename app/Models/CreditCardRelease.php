<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditCardRelease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'data_compra',
        'valor',
        'quantidade_parcelas',
        'descricao',
        'valor_parcela',
        'valor_pago_fatura',
        'data_pagamento_fatura',
        'period_id',
        'credit_card_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

}
