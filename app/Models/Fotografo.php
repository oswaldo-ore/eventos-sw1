<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografo extends User
{
    use HasFactory;

    protected $table = "fotografos";

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'suscriptions');
    }
}