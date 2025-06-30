<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

</head>
<body>
    <h1>Registrarse</h1>

    <!-- Mostrar errores de validación si existen -->
    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Formulario de registro -->
    <form action="{{ url('registeradmin') }}" method="POST">
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Registrarse</button>
    </form>

    <!-- Opción para iniciar sesión -->
    <p>¿Ya tienes cuenta? <a href="{{ route('loginadmin') }}">Inicia sesión</a></p>
</body>
</html>
