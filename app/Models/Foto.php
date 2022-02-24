<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Foto extends Model
{
    use HasFactory;
    protected $timestamp = true;
    protected $table = "fotos";
    protected $fillable = [
        "id", "url", "fotografo_id", "evento_id"
    ];

    public function faces()
    {
        return  $this->hasMany(Face::class);
    }
}
