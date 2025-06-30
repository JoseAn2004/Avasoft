<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'metodo',
        'codigo_operacion',
        'imagen_voucher',
        'fecha_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
