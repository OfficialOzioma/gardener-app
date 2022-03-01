<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Location extends Model
{
    use HasApiTokens, HasFactory;


    public function customers()
    {
        return $this->hasMany(User::class);
    }

    public function gardeners()
    {
        return $this->hasMany(Gardener::class);
    }
}
