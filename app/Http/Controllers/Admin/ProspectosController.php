<?php

namespace App\Http\Controllers\Admin;

use App\Models\Suscriptor;  // Importa el modelo Admin
use App\Http\Controllers\Controller;

class ProspectosController extends Controller
{
    public function index()
    {
        $suscriptores = Suscriptor::paginate(10); // o ->get() si no usas paginación
        return view('admin.prospectos.index', compact('suscriptores'));
    }
}
