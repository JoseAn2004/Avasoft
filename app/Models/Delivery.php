<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';

    protected $fillable = [
        'order_id',
        'tipo_entrega',
        'direccion',
        'ubicacion',
        'fecha_entrega',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
