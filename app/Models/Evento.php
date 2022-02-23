<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'title', 'description', 'lat', 'lon', 'location', 'date', 'cliente_id',
    ];

    protected $hidden = [
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function fotografos()
    {
        return $this->belongsToMany(Fotografo::class, Suscripcion::class);
    }

    public function fotografoPhotos()
    {
        return $this->belongsToMany(Fotografo::class, Foto::class);
    }
}
