<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule; // Agrega esta línea arriba en el controlador

use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function miperfil()
    {
        $usuario = Auth::user();
        return view('vistapublica.miperfil', compact('usuario'));
    }
    public function actualizar(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return back()->withErrors(['error' => 'Usuario no autenticado']);
        }

        // Debug para ver qué tienes realmente
        // dd($usuario, get_class($usuario));

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $usuario->id,
            'dni'      => 'required|string|max:20',
            'telefono' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);


        $usuario->name  = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->save();

        // ✅ Evita duplicados
        $perfil = UserProfile::firstOrNew(['user_id' => $usuario->id]);
        $perfil->dni       = $request->input('dni');
        $perfil->telefono  = $request->input('telefono');
        $perfil->save();



        return back()->with('success', 'Perfil actualizado correctamente');
    }

    public function actualizarDireccion(Request $request)
    {
        $usuario = Auth::user();

        if (!$usuario) {
            return back()->withErrors(['error' => 'Usuario no autenticado']);
        }

        $request->validate([
            'direccion' => 'required|string|max:255',
        ]);

        // Buscar el perfil existente, si no existe aún, crearlo
        $perfil = \App\Models\UserProfile::firstOrNew(['user_id' => $usuario->id]);

        $perfil->direccion = $request->input('direccion');
        $perfil->save();

        return back()->with('success', 'Dirección guardada correctamente');
    }
}
