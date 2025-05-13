<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes',
        'ano',
        'saldo_inicial',
        'saldo_atual',
        'descricao',
        'observacao',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function periodReleases(): HasMany
    {
        return $this->hasMany(PeriodRelease::class);
    }

    public function creditCardReleases(): HasMany
    {
        return $this->hasMany(CreditCardRelease::class);
    }

    public function carReleases(): HasMany
    {
        return $this->hasMany(CarRelease::class);
    }
}
