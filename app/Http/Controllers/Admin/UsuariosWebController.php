<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;


use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class UsuariosWebController extends Controller
{
    public function index()
    {
        $users = User::paginate(10); // Paginación de 10 usuarios
        return view('admin.usuariosweb.index', compact('users'));
    }

    
    public function exportPdf()
    {
        $users = User::all();
        $pdf = PDF::loadView('admin.usuariosweb.pdf', compact('users'));
        return $pdf->download('usuarios_web.pdf');
    }


    public function exportExcel()
    {
        return Excel::download(new UsuariosExport, 'usuarios_web.xlsx');
    }
}

