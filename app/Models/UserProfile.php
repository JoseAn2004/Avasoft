<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // Habilita asignación masiva
    protected $fillable = ['user_id', 'dni', 'telefono', 'direccion'];

    // Relación inversa con User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
