<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NICK STORE - Iniciar sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/login.css', 'resources/js/app.js'])
    
</head>
<body style="
    background-image: url('{{ asset('images/login12.png') }}');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    height: 100vh;
    margin: 0;
">

    <div class="main-container">
        <div class="logo-section">
            <div class="logo-content">
                <img src="{{ asset('images/logo.png') }}" alt="NICK STORE" class="logo-img">
               <!-- <img src="" alt="Tu tienda favorita" class="slogan-img">     -->           
            </div>
        </div>
        
        <!-- Sección del formulario (derecha) -->
        <div class="form-section">
            <h2 class="form-title">INICIAR SESIÓN</h2>

            <!-- Mostrar errores de login si existen -->
            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Formulario de login -->
            <form action="{{ url('loginadmin') }}" method="POST">
                @csrf
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="email" name="email" id="email" placeholder="Correo o usuario" required>
                </div>

                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required>
                </div>

                <button type="submit" class="btn-login">INGRESAR</button>
                
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
            </form>
            <!-- Opción para registrarse 
            <p class="register-link">¿Aún no tienes cuenta? <a href="{{ route('registeradmin') }}">Regístrate</a></p>-->
        </div>
    </div>
</body>
</html>