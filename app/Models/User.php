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

    //um usuário está em muitos typeReleases
    public function typeReleases(): HasMany
    {
        return $this->hasMany(TypeRelease::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function carReleases(): HasMany
    {
        return $this->hasMany(CarRelease::class);
    }

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function creditCardReleases(): HasMany
    {
        return $this->hasMany(CreditCardRelease::class);
    }

    public function periods(): HasMany
    {
        return $this->hasMany(Period::class);
    }

    public function periodReleases(): HasMany
    {
        return $this->hasMany(PeriodRelease::class);
    }
}
