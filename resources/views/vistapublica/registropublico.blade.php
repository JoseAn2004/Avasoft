@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="flex justify-center py-12 bg-white">
    <div class="w-full max-w-5xl flex flex-col md:flex-row">
        
        <!-- Columna izquierda: mensaje motivador -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center items-center">
            <div class="text-center max-w-sm">
                <h2 class="text-2xl font-bold text-orange-600 mb-4">Bienvenido a tu nueva experiencia</h2>
                <p class="text-sm text-gray-700">
                    Regístrate para tener acceso a todas las funciones exclusivas. Descubre lo que podemos hacer por ti.
                </p>
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User Icon" class="w-32 mx-auto mt-6 opacity-80" />
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="hidden md:block w-px bg-gray-300"></div>

        <!-- Columna derecha: formulario -->
        <div class="md:w-1/2 p-10 flex flex-col justify-center items-center">
            <div class="w-full max-w-sm">
                <h2 class="text-xl font-semibold mb-6 text-center">Crear una cuenta</h2>

                <form method="POST" action="{{ route('registro') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                        <input 
                            type="text" 
                            name="name" 
                            placeholder="Juan Pérez"
                            class="w-full px-3 py-2 border-b border-orange-300 focus:border-orange-500 outline-none transition"
                            required
                        />
                    </div>

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
                            id="password"
                            placeholder="Crea una contraseña segura"
                            class="w-full px-3 py-2 border-b border-orange-300 focus:border-orange-500 outline-none transition"
                            required
                        />
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                placeholder="Repite tu contraseña"
                                class="w-full px-3 py-2 border-b border-orange-300 focus:border-orange-500 outline-none transition"
                                required
                            />
                            <span id="match-icon" class="text-xl"></span>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-orange-400 text-white hover:bg-orange-500 transition text-sm font-semibold rounded"
                    >
                        Registrarme
                    </button>

                    <div class="mt-6 text-center text-sm text-gray-600">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('vistapublica.iniciarsession') }}" class="text-orange-600 font-medium hover:underline">Inicia sesión</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Scripts para validación y SweetAlert --}}
@push('scripts')
    @if (session('registro_exitoso'))
    <script>
        Swal.fire({
            title: '¡Registro exitoso!',
            text: 'Serás redirigido a tu perfil en un momento.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "{{ route('perfil.ver') }}";
        });
    </script>
    @endif

    <script>
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        const matchIcon = document.getElementById('match-icon');

        function checkPasswordMatch() {
            if (password.value === "" && passwordConfirmation.value === "") {
                matchIcon.innerHTML = '';
                return;
            }

            if (password.value === passwordConfirmation.value) {
                matchIcon.innerHTML = '✔️';
                matchIcon.classList.remove('text-red-500');
                matchIcon.classList.add('text-green-500');
            } else {
                matchIcon.innerHTML = '❌';
                matchIcon.classList.remove('text-green-500');
                matchIcon.classList.add('text-red-500');
            }
        }

        password.addEventListener('input', checkPasswordMatch);
        passwordConfirmation.addEventListener('input', checkPasswordMatch);
    </script>
@endpush
