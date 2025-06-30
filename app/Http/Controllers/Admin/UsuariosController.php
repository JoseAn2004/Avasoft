<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;  // Importa el modelo Admin
use App\Http\Controllers\Controller;

class UsuariosController extends Controller
{
   public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.usuarios.index', compact('admins'));
    }

}
