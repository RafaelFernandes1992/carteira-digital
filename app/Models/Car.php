<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'renavam',
        'placa',
        'marca',
        'modelo',
        'apelido',
        'data_aquisicao',
        'user_id',
    ];

    public function getNome(): string
    {
        return "$this->apelido";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function carReleases(): HasMany
    {
        return $this->hasMany(CarRelease::class);
    }
}
