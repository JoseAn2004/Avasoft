<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mi carrito Avasoft</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Red Hat Display', sans-serif;
        }

        input[type="text"]::placeholder {
            color: #9ca3af;
        }
    </style>
</head>

<body class="bg-gray-100 pb-32">
    <!-- Header -->
    <header class="bg-orange-500 shadow-md p-4">
        <div class="container mx-auto flex items-center space-x-4">
            <img src="{{ asset('images/logong.png') }}" alt="Logo" class="h-14 ml-4 w-38">
            <!--<span class="text-white-500 font-extrabold text-xl"></span>-->
        </div>
    </header>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 pt-6 pb-32">
        <!-- Botón volver -->
        <button onclick="window.location.href='/'" class="flex items-center text-sm text-gray-600 hover:text-gray-800 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al inicio
        </button>

        <!-- Título -->
        <h1 class="text-2xl font-bold mb-6 text-left border-b border-gray-300 pb-2">Mi carrito</h1>

        <div class="flex flex-col lg:flex-row items-start gap-6">
            <!-- Contenedor de productos -->
            <section class="flex-[2] bg-white rounded-lg shadow-md p-6 w-full" id="carritoContainer">
                <!-- Aquí se insertan los productos -->
            </section>

            <!-- Contenedor de totales y cupón -->
            <aside class="flex-[1] bg-white rounded-lg shadow-md p-6 w-full lg:w-96">
                <div class="mb-6 flex justify-center">
                    <img src="{{ asset('images/pago-seguro.png') }}" alt="" class="w-20">
                </div>

                <!-- Botón agregar cupón -->
                <div class="border-t border-b border-gray-200 py-4 mb-4">
                    <button onclick="toggleCupon()" class="flex items-center justify-between w-full text-blue-600 font-semibold py-2 px-3 rounded-md hover:bg-blue-50">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Agregar cupón</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>

                    <div id="cuponInputContainer" class="mt-3 hidden">
                        <input
                            type="text"
                            maxlength="8"
                            placeholder="Ingrese su cupón"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 mt-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-300"
                            oninput="validarCupon(this)" />
                        <p class="text-xs text-gray-500 mt-1">Solo letras mayúsculas (A-Z) y números del 1 al 9.</p>
                    </div>
                </div>

                <!-- Totales -->
                <div class="text-sm text-gray-700 mb-2 flex justify-between">
                    <span>Subtotal</span>
                    <span class="font-semibold" id="subtotalText">S/ 0.00</span>
                </div>
                <div class="text-lg font-bold text-gray-900 flex justify-between">
                    <span>Total</span>
                    <span id="totalText">S/ 0.00</span>
                </div>
            </aside>
        </div>
    </main>


    <!-- Footer fijo -->
    <footer class="bg-white p-4 shadow-md fixed bottom-0 left-0 w-full z-50">
        <div class="container mx-auto flex justify-end">
            <button onclick="procederPago()" class="bg-red-600 text-white font-bold py-3 px-6 rounded-full flex items-center space-x-2 hover:bg-red-700 transition duration-300 shadow-md">
                <span>Continuar compra</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                </svg>
            </button>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function renderCarritoClaro() {
            const carter = JSON.parse(localStorage.getItem('carter')) || [];
            const contenedor = document.getElementById('carritoContainer');
            const subtotalText = document.getElementById('subtotalText');
            const totalText = document.getElementById('totalText');

            contenedor.innerHTML = '';
            let total = 0;

            if (carter.length === 0) {
                contenedor.innerHTML = '<p class="text-gray-500">Tu carrito está vacío.</p>';
                subtotalText.textContent = 'S/ 0.00';
                totalText.textContent = 'S/ 0.00';
                return;
            }

            carter.forEach((item, index) => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;

                const isLast = index === carter.length - 1;
                contenedor.innerHTML += `
                    <div class="flex items-center space-x-4 ${!isLast ? 'border-b border-gray-200 pb-4 mb-4' : ''}">
                        <img src="${item.imagen}" alt="${item.nombre}" class="w-24 h-24 object-contain">
                        <div class="flex-1">
                            <h2 class="font-semibold text-gray-800">${item.nombre}</h2>
                            <p class="text-sm text-gray-600">${item.talla || 'Talla única'}</p>
                            <p class="text-xs text-red-500 font-semibold">${item.cantidad} x S/ ${item.precio.toFixed(2)}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-700 text-sm">Pago único</p>
                            <p class="font-bold text-lg text-gray-900">S/ ${subtotal.toFixed(2)}</p>
                        </div>
                    </div>
                `;
            });


            subtotalText.textContent = `S/ ${total.toFixed(2)}`;
            totalText.textContent = `S/ ${total.toFixed(2)}`;
        }

        function procederPago() {
            const carter = JSON.parse(localStorage.getItem('carter')) || [];

            if (carter.length === 0) {
                alert("Tu carrito está vacío.");
                return;
            }

            // Aquí podrías guardar cualquier otra info adicional si es necesario
            localStorage.setItem('paso_a_checkout', '1'); // Marca que el usuario quiere pagar

            // Redirige a la vista del checkout
            window.location.href = "/checkout"; // Asegúrate de tener esta ruta en Laravel

        }

        function toggleCupon() {
            document.getElementById('cuponInputContainer').classList.toggle('hidden');
        }

        function validarCupon(input) {
            input.value = input.value.toUpperCase().replace(/[^A-Z1-9]/g, '');
        }

        window.onload = renderCarritoClaro;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>

</html>