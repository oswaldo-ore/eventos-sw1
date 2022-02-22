<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends User
{
    use HasFactory;

    protected $table = "clientes";


    public function avatars()
    {
        return $this->hasMany(Avatar::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }
}
