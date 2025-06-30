<?php

//* app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Muestra el formulario de login
    public function showLoginForm()
    {
        return view('auth.loginadmin');
    }

    // Procesa el login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Intentar hacer login con las credenciales
        if (Auth::attempt($credentials)) {
            // Redirigir a la página de inicio si el login es exitoso
            return redirect()->intended('admin.inicio');
        }

        // Si las credenciales son incorrectas, volver al login con un error
        return redirect('loginadmin')->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

        public function logout(Request $request)
    {
        // Verifica qué guard está autenticado y cierra la sesión correctamente
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
            $redirectRoute = 'auth.loginadmin'; // Redirigir a la página de login del admin
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            $redirectRoute = 'vistapublica.iniciarsession'; // Redirigir a la página de login del cliente
        }

        // Invalida la sesión y regenera el token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige según el guard que estaba activo
        return redirect()->route($redirectRoute);
    }


}
