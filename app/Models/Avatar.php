<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;
    protected $fillable = [
        "id", "url", "face_id", "image_id", "cliente_id", "external_id"
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
