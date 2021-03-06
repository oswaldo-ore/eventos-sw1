<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Suscripcion extends Pivot
{
    use HasFactory;

    protected $table = "suscripcions";
    public $timestamps = true;

    protected $fillable = ["id", "accepted", "fotografo_id", "evento_id"];
}
