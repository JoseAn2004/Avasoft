<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    protected $table = 'tipo_productos'; // <- Esto está perfecto si la tabla se llama en plural
}
