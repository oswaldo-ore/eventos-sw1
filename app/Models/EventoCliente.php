<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventoCliente extends Pivot
{
    use HasFactory;

    protected $table = "evento_clientes";
    protected $fillable = ["id", "cliente_id", "evento_id"];
}
