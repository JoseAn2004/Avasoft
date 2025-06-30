<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile; // Asegúrate de importar el modelo

class UserRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('vistapublica.registropublico'); // Tu vista de registro
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            \Log::info('▶ Iniciando registro...');

            // Crear el usuario
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            \Log::info('✅ Usuario creado con ID: ' . $user->id);

            // Crear perfil vacío
            $user->perfil()->create([
                'dni'       => '',
                'telefono'  => '',
                'direccion' => '',
            ]);

            \Log::info('✅ Perfil creado');

            // Loguear al usuario automáticamente
            Auth::guard('web')->login($user);

            \Log::info('✅ Usuario logueado');

            // Redirigir
            return redirect()->route('registro.form')->with('registro_exitoso', true);
        } catch (\Exception $e) {
            \Log::error('❌ Error en el registro: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Fallo al registrar: ' . $e->getMessage()]);
        }
    }
}
