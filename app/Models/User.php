<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email'
    ];
    protected $hidden = [
        'password'
    ];

    //um usuário está em muitos postings
    public function postings(): HasMany
    {
        return $this->hasMany(Posting::class);
    }
}
