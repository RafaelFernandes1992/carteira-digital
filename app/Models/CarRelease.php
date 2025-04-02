<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_despesa',
        'valor',
        'descricao',
        'period_release_id',
        'car_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function periodRelease(): BelongsTo
    {
        return $this->belongsTo(PeriodRelease::class);
    }
}
