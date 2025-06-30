<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritosController extends Controller
{
    public function index()
    {
        return view('favorito'); // Solo 'usuarios' si está en resources/views/usuarios.blade.php
    }
}
