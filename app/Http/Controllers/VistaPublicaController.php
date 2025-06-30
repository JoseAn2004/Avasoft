<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VistaPublicaController extends Controller
{
    public function new()
    {
        return view('vistapublica.new'); // Asegúrate de tener esta vista
    }
    public function hombre()
    {
        return view('vistapublica.hombre'); // Asegúrate de tener esta vista
    }
    public function mujer()
    {
        return view('vistapublica.mujer'); // Asegúrate de tener esta vista
    }
    public function iniciarsession()
    {
        return view('vistapublica.iniciarsession'); // Asegúrate de tener esta vista
    }
    public function registropublico()
    {
        return view('vistapublica.registropublico'); // Asegúrate de tener esta vista
    }
   
   
}
