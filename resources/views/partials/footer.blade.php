<footer class="bg-gray-900 text-white py-10 ">
    <div class="container mx-auto">
        <!-- Contenedor principal en 3 columnas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <!-- Columna 1: Redes sociales -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Síguenos en</h3>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-white hover:text-gray-400">
                        <i class="fab fa-tiktok fa-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Columna 2: Medios de pago -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Medios de pago</h3>
                <div class="flex justify-center space-x-2">
                    <img src="{{ asset('images/iconovisa.jpg') }}" alt="Visa" class="h-8">
                    <img src="{{ asset('images/iconomaster.png') }}" alt="Mastercard" class="h-8">
                    <img src="{{ asset('images/pagoefec.png') }}" alt="PagoEfectivo" class="h-8">
                    <img src="{{ asset('images/logoplin.png') }}" alt="Plin" class="h-8">
                    <img src="{{ asset('images/logoyape.png') }}" alt="Yape" class="h-8">
                </div>
            </div>

            <!-- Columna 3: Seguridad -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Tienda online</h3>
                <p>100% Segura</p>
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="border-t border-gray-700 my-4"></div>

        <!-- Derechos reservados -->
        <p class="text-sm text-center">&copy; {{ date('Y') }} Mi Tienda. Todos los derechos reservados.</p>
    </div>
</footer>