<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Le decimos a Laravel que use la tabla 'admins'
    protected $table = 'admins';

    // Campos que pueden asignarse en masa
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos ocultos cuando el modelo se convierte a array o JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
}
