<div id="envio" class="fixed top-0 left-0 w-full z-30">
    <div class="bg-orange-500 text-white text-lg font-medium text-center py-1 border-b border-orange-300">
        <i class="fas fa-truck mr-2 text-white"></i> 
        <span class="static-text">¡Envíos gratis a partir de 100 soles!</span> 
        <i class="fas fa-truck ml-2 text-white"></i>
    </div>

    <nav id="navbar" class="bg-white border-b border-gray-300 px-6 py-4 flex justify-between items-center shadow-none w-full">
        <a href="/" class="flex items-center gap-2">
            <img src="{{ asset('images/logong.png') }}" alt="Logo" class="h-14 w-38">
            <span class="text-orange-500 font-bold text-xl"></span>
        </a>

        <div class="flex-1 mx-6 relative">
            <input
                type="text"
                id="busqueda"
                placeholder="Buscar productos, marcas..."
                class="w-full py-2 pl-5 pr-12 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm text-gray-800 placeholder-gray-400 transition"
                autocomplete="off"
            />
            <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-orange-400 text-lg"></i>
            <ul id="resultadosBusqueda" class="absolute bg-white border border-gray-300 w-full mt-1 rounded-md max-h-48 overflow-auto z-50 hidden"></ul>
        </div>

        <div class="flex items-center gap-6 text-gray-700 text-xl relative">
            <div class="relative group">
                <div class="cursor-pointer hover:text-orange-500 transition duration-300">
                    <i class="fas fa-user"></i>
                </div>

                @guest
                <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
                    <a href="{{ route('vistapublica.iniciarsession') }}" class="block px-4 py-2 hover:bg-orange-50 text-sm text-gray-700">Iniciar sesión</a>
                    <a href="{{ route('vistapublica.registropublico') }}" class="block px-4 py-2 hover:bg-orange-50 text-sm text-gray-700">Registrarse</a>
                </div>
                @endguest

                @auth
                <div class="absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
                    <a href="{{ route('perfil.ver') }}" class="block px-4 py-2 hover:bg-orange-50 text-sm text-gray-700">Mi perfil</a>
                    <a href="{{ route('perfil.ver') }}?tab=pedidos" class="block px-4 py-2 hover:bg-orange-50 text-sm text-gray-700">Mis pedidos</a>
                    <form method="POST" action="{{ route('logout.cliente') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-orange-50 text-sm text-gray-700">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
                @endauth
            </div>

            <!-- Favoritos -->
            @if(auth()->check())
                <a href="{{ route('perfil.ver') }}?tab=favoritos" title="Mis favoritos">
                    <i class="fas fa-heart hover:text-orange-500 transition duration-300"></i>
                </a>
            @else
                <a href="#" onclick="mostrarAlertaFavoritos(event)" title="Mis favoritos">
                    <i class="fas fa-heart hover:text-orange-500 transition duration-300"></i>
                </a>
            @endif

            <!-- Carrito -->
            <a href="#" title="Carrito" onclick="toggleCartDrawer(); return false;" class="relative">
                <i class="fas fa-shopping-cart text-xl hover:text-orange-500 transition duration-300"></i>
                <span id="cartCount" class="absolute -top-2 -right-2 bg-red-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
            </a>
        </div>
    </nav>

    <ul class="flex justify-center list-none gap-12 py-4 bg-white border-b border-gray-300/50 transition-transform duration-300 ease-in-out">
        <li>
            <a href="{{ route('vistapublica.new') }}" class="text-orange-500 text-lg font-semibold hover:underline underline-offset-4 decoration-2 decoration-orange-400 hover:text-black transition-colors duration-300">
                New
            </a>
        </li>
        <li>
            <a href="{{ route('vistapublica.hombre') }}" class="text-orange-500 text-lg font-semibold hover:underline underline-offset-4 decoration-2 decoration-orange-400 hover:text-black transition-colors duration-300">
                Hombre
            </a>
        </li>
        <li>
            <a href="{{ route('vistapublica.mujer') }}" class="text-orange-500 text-lg font-semibold hover:underline underline-offset-4 decoration-2 decoration-orange-400 hover:text-black transition-colors duration-300">
                Mujer
            </a>
        </li>
        <li>
            <a href="{{ route('vistapublica.accesorios') }}" class="text-orange-500 text-lg font-semibold hover:underline underline-offset-4 decoration-2 decoration-orange-400 hover:text-black transition-colors duration-300">
                Accesorios
            </a>
        </li>
    </ul>
</div>



<!-- Overlay oscuro que cubre la pantalla cuando el drawer está abierto -->
<div id="cartOverlay" class="fixed inset-0 z-40 hidden" style="background-color: rgba(0, 0, 0, 0.1);" onclick="toggleCartDrawer()"></div>

<!-- Drawer del carrito -->
<div id="cartDrawer" class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <!-- Cabecera del drawer -->
    <div class="bg-orange-400 text-white p-4 flex justify-between items-center">
        <h2 class="text-lg font-semibold">Mi Carrito</h2>
        <button onclick="toggleCartDrawer()" class="text-white hover:text-orange-100">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <!-- Contenido del carrito -->
    <div class="p-4 overflow-y-auto h-[calc(100%-8rem)]">
        <div id="emptyCartMessage" class="text-center py-8 text-gray-500 hidden">
            <i class="fas fa-shopping-cart text-4xl mb-3"></i>
            <p>Tu carrito está vacío</p>
        </div>
        <div id="cartItems"></div>
    </div>
    
    <!-- Footer con total y botón -->
    <div class="absolute bottom-0 left-0 right-0 bg-white p-4 border-t">
        <div class="flex justify-between mb-4">
            <span class="font-medium">Total:</span>
            <span id="totalAmount" class="font-bold">S/ 0.00</span>
        </div>
        <button id="generateInvoiceBtn" class="w-full bg-orange-400 text-white py-2 rounded hover:bg-orange-500 transition">
            Proceder al pago
        </button>
    </div>
</div>


<!-- JavaScript para controlar el drawer -->
<script>
    function toggleCartDrawer() {
        const drawer = document.getElementById('cartDrawer');
        const overlay = document.getElementById('cartOverlay');
        
        drawer.classList.toggle('translate-x-full');
        
        if (drawer.classList.contains('translate-x-full')) {
            overlay.classList.add('hidden');
            document.body.style.overflow = '';  // Permitir scroll en el fondo
        } else {
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';  // Bloquear scroll en el fondo
        }
    }
    
</script>
<script>
    const loginUrl = {!! json_encode(route('vistapublica.iniciarsession')) !!};

    function mostrarAlertaFavoritos(e) {
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Acceso no permitido',
            html: 'Debes <a href="' + loginUrl + '" class="text-orange-500 underline font-medium">iniciar sesión</a> para ver tus favoritos.',
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg shadow-lg px-6 py-5',
                title: 'text-lg font-bold',
                htmlContainer: 'text-sm text-gray-700'
            }
        });
    }
</script>
<script>
    const inputBusqueda = document.getElementById('busqueda');
const resultadosBusqueda = document.getElementById('resultadosBusqueda');

inputBusqueda.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length < 2) {
        resultadosBusqueda.innerHTML = '';
        resultadosBusqueda.classList.add('hidden');
        return;
    }

    fetch(`/buscar-productos?term=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) throw new Error('Respuesta no OK');
            return response.json();
        })
        .then(data => {
            resultadosBusqueda.innerHTML = '';

            if (data.length === 0) {
                resultadosBusqueda.innerHTML = '<li class="px-4 py-2 text-gray-500">No hay resultados</li>';
            } else {
                data.forEach(item => {
                    const li = document.createElement('li');
                    li.classList.add('px-4', 'py-2', 'cursor-pointer', 'hover:bg-orange-100');
                    li.textContent = `${item.nombre} - ${item.marca}`;
                    li.addEventListener('click', () => {
                        const productoElemento = document.getElementById(`producto-${item.id}`);
                        if (productoElemento) {
                            productoElemento.scrollIntoView({ behavior: 'smooth', block: 'start' });

                            // Opcional: resaltar visualmente el producto
                            productoElemento.classList.add('highlight');
                            setTimeout(() => {
                                productoElemento.classList.remove('highlight');
                            }, 2000);

                            resultadosBusqueda.classList.add('hidden');
                            inputBusqueda.value = '';
                        } else {
                            alert('Producto no encontrado en la página.');
                        }
                    });
                    resultadosBusqueda.appendChild(li);
                });
            }
            resultadosBusqueda.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error al buscar:', error);
            resultadosBusqueda.innerHTML = '<li class="px-4 py-2 text-red-500">Error al buscar</li>';
            resultadosBusqueda.classList.remove('hidden');
        });
});



</script>


<style>
    .highlight {
        background-color:rgb(255, 178, 90); /* Amarillo claro */
        transition: background-color 4s ease;
    }
</style>


   




<!-- GSAP Animations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.1/gsap.min.js"></script>
<script>
    gsap.from('#envio', { opacity: 0, y: -50, duration: 1, ease: 'power3.out' });
    
</script>
<script>
    const isLoggedIn = @json(Auth::check());
</script>





<script>
    window.onload = () => {
        renderCarter(); // función que ya tienes en tu JS
    };
</script>








<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

