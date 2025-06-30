<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Define los campos que son "masivos asignables"
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion_corta',
        'precio',
        'precio_descuento',
        'stock',
        'imagen_principal',
        'categoria_id',
        'tipo_producto_id',
        'marca_id',
        'estado',
        'destacado'
    ];


    // Definir la relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto_id');
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    // ✅ Relación con tallas (muchos a muchos)
    public function tallas()
    {
        return $this->belongsToMany(Talla::class, 'producto_talla', 'producto_id', 'talla_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
