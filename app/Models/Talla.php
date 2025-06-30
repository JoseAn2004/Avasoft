<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Talla extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_talla', 'talla_id', 'producto_id');
    }
}
