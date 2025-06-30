<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Guarda la URL donde estaba el usuario antes de iniciar sesión
        if ($request->has('returnTo')) {
            session(['url.intended' => $request->get('returnTo')]);
        }

        return view('vistapublica.iniciarsession');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            return redirect()->intended('/'); // Si no hay returnTo, va a /carrito
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas para cliente.',
        ])->withInput($request->only('email'));
    }


    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

   
}
