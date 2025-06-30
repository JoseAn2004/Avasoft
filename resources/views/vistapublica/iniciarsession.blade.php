@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="flex justify-center py-12 bg-white">
    <div class="w-full max-w-5xl flex flex-col md:flex-row">
        
        <!-- Columna izquierda -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center items-center">
            <div class="w-full max-w-sm">
                <h2 class="text-xl font-semibold mb-6 text-center">Acceso rápido</h2>

                <div class="space-y-4">
                    <button class="w-full py-3 px-4 border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-sm font-medium">
                        Ingresar con Código
                    </button>
                    <button class="w-full py-3 px-4 border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-sm font-medium">
                        Ingresar con Google
                    </button>
                    <button class="w-full py-3 px-4 border border-gray-300 flex items-center justify-center hover:bg-gray-100 transition text-sm font-medium">
                        Ingresar con Facebook
                    </button>
                </div>
            </div>
        </div>

        <!-- Línea divisoria vertical -->
        <div class="hidden md:block w-px bg-gray-300"></div>

        <!-- Columna derecha -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center items-center">
            <div class="w-full max-w-sm">
                <h2 class="text-xl font-semibold mb-6 text-center">Entrar con correo</h2>

                <form method="POST" action="{{ route('login.cliente') }}">
                    @csrf

                    @if($errors->any())
                        <div class="mb-4 text-red-600 text-sm">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="usuario@gmail.com"
                            class="w-full px-3 py-2 border-b border-orange-300 focus:border-orange-500 outline-none transition"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Ingrese su contraseña"
                            class="w-full px-3 py-2 border-b border-orange-300 focus:border-orange-500 outline-none transition"
                            required
                        />
                    </div>

                    <div class="mb-6 text-right">
                        <a href="#" class="text-sm text-gray-600 hover:text-gray-800">Olvidé mi contraseña</a>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-orange-400 text-white hover:bg-orange-500 transition text-sm"
                    >
                        Ingresar
                    </button>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        ¿No tiene una cuenta?
                        <a href="{{ route('vistapublica.registropublico') }}" class="text-gray-800 font-medium hover:underline">Regístrese</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
