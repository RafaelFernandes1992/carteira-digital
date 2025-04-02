<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'descricao',
        'rotineira',
        'dedutivel',
        'isenta',
        'tipo',
        'user_id'
    ];

    //um posting pertence a um usuário
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
