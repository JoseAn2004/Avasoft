<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/png" href="{{ asset('images/vtadmin/img/logotre2.png') }}"/>
        
        <title>Avasoft</title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Nucleo Icons -->
        @vite('public/assets/css/nucleo-svg.css')
        @vite('public/assets/css/nucleo-icons.css')
        <!-- Popper -->
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <!-- Main Styling -->
        @vite('resources/css/app.css')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>



    </head>

    <body>
        
        @include('partials.navadmin')

        <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
            <section >
                    @yield('content')
            </section>
            @include('partials.piedmin')
        </main>

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
        <script src="//unpkg.com/alpinejs" defer></script>

    </body>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo del botón para abrir el modal
    document.getElementById('btnNuevoCliente').addEventListener('click', function() {
        document.getElementById('modalNuevoCliente').classList.remove('hidden');
    });

    // Función para cerrar el modal
    function cerrarModal() {
        const modal = document.getElementById('modalNuevoCliente');
        modal.classList.add('hidden');
        
        // Limpiar el formulario
        const form = document.getElementById('formNuevoCliente');
        form.reset();
    }

    // Manejo del botón cancelar
    document.querySelector('#modalNuevoCliente button[type="button"]').addEventListener('click', function() {
        cerrarModal();
    });

    // Manejo del formulario
    document.getElementById('formNuevoCliente').addEventListener('submit', function(e) {
        e.preventDefault();
        // Aquí iría la lógica para guardar el cliente
        cerrarModal();
    });

    // Manejo del click fuera del modal
    document.getElementById('modalNuevoCliente').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });

    // Manejo de la tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModal();
        }
    });
});
</script>
   

</html>
