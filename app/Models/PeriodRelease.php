<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodRelease extends Model
{
    use HasFactory;
    protected $fillable = [
        'valor_total',
        'observacao',
        'data_debito_credito',
        'situacao',
        'user_id',
        'period_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function carReleases(): HasMany
    {
        return $this->hasMany(CarRelease::class);
    }

    public function creditCardReleases(): HasMany
    {
        return $this->hasMany(CreditCardRelease::class);
    }
}
