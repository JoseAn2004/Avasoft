@extends('layouts.app')

@section('title', 'Avalach CoM')

@section('content')
<section>
    <div class="relative w-full overflow-hidden">
        <div id="carrusel" class="flex transition-transform duration-700 ease-in-out">
            <img src="{{ asset('images/imagenini.png') }}" class="w-full max-h-120 object-cover flex-shrink-0" alt="Imagen 1">
            <img src="{{ asset('images/fond.png') }}" class="w-full max-h-120 object-cover flex-shrink-0" alt="Imagen 2">
            <img src="{{ asset('images/fond2.jpg') }}" class="w-full max-h-120 object-cover flex-shrink-0" alt="Imagen 3">
        </div>
    </div>
</section>

<script>
    const carrusel = document.getElementById('carrusel');
    const totalSlides = carrusel.children.length;
    let currentIndex = 0;

    setInterval(() => {
        currentIndex++;

        if (currentIndex >= totalSlides) {
            // Reinicio sin animación
            carrusel.style.transition = 'none';
            carrusel.style.transform = 'translateX(0)';
            currentIndex = 1;

            // Forzamos el repaint y aplicamos nuevamente la transición
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    carrusel.style.transition = 'transform 1.5s ease-in-out';
                    carrusel.style.transform = `translateX(-${currentIndex * 100}%)`;
                });
            });
        } else {
            carrusel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
    }, 4000);
</script>



<section class="init1 bg-gradient-to-b from-gray-50 to-white py-16">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Encabezado -->
        <div class="text-center mb-14">
            <h2 class="text-4xl font-extrabold text-gray-800 tracking-tight">Novedades</h2>
            <p class="text-gray-500 text-lg mt-2">Descubre los últimos lanzamientos que tenemos para ti</p>
            <div class="w-24 h-1 bg-orange-500 mt-5 rounded-full mx-auto"></div>
        </div>

        @if($productosNuevos->isEmpty())
        <p class="text-center text-gray-600 text-lg py-20">
            Por el momento no hay nuevos ingresos.
        </p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8">
            @foreach($productosNuevos as $producto)
            <div
                x-data="{ tallaSeleccionada: null, cantidad: 1 }"
                class="bg-white rounded-3xl shadow-md hover:shadow-lg transition duration-300 flex flex-col overflow-hidden">
                <!-- Imagen -->
                <div class="relative bg-gray-50 h-[260px] flex items-center justify-center">
                    <img src="{{ asset($producto->imagen_principal) }}" alt="{{ $producto->nombre }}"
                        class="max-h-full max-w-[90%] object-contain transition-transform duration-300 hover:scale-105">
                    <button
                        class="btn-favorito absolute top-4 right-4 text-xl z-10"
                        data-id="{{ $producto->id }}"
                        data-nombre="{{ $producto->nombre }}"
                        data-imagen="{{ asset($producto->imagen_principal) }}">
                        <i class="{{ in_array($producto->id, $favoritosIds ?? []) ? 'fas text-red-500' : 'far text-gray-400' }} fa-heart hover:text-red-500 transition duration-300"></i>
                    </button>


                </div>

                <!-- Contenido -->
                <div class="p-4 flex flex-col flex-grow space-y-4">
                    <!-- Nombre y descripción -->
                    <div class="text-left">
                        <h3 class="text-[15px] font-semibold text-gray-800 mb-1 break-words" title="{{ $producto->nombre }}">
                            {{ $producto->nombre }}
                        </h3>
                        <p class="text-xs text-gray-600 text-justify break-words leading-snug" title="{{ $producto->descripcion }}">
                            {{ $producto->descripcion }}
                        </p>
                    </div>

                    <!-- Precio -->
                    <div class="text-left">
                        @if($producto->precio_descuento)
                        <span class="text-red-500 text-xs line-through">S/ {{ number_format($producto->precio, 2) }}</span>
                        <span class="ml-2 text-orange-600 text-base font-bold">S/ {{ number_format($producto->precio_descuento, 2) }}</span>
                        @else
                        <span class="text-orange-600 text-base font-bold">S/ {{ number_format($producto->precio, 2) }}</span>
                        @endif
                    </div>

                    <!-- Tallas -->
                    @if($producto->tallas && count($producto->tallas))
                    <div>
                        <p class="text-xs font-medium text-gray-700 mb-1">Talla:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($producto->tallas as $talla)
                            <label
                                class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center cursor-pointer text-xs hover:bg-orange-100 transition"
                                :class="{ 'bg-orange-500 text-white border-orange-500': tallaSeleccionada === '{{ $talla->nombre }}' }">
                                <input type="radio"
                                    name="talla_{{ $producto->id }}"
                                    value="{{ $talla->nombre }}"
                                    x-model="tallaSeleccionada"
                                    class="sr-only">
                                {{ $talla->nombre }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Cantidad + botón -->
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(cantidad > 1) cantidad--"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">-</button>
                            <span class="text-sm font-medium w-6 text-center" x-text="cantidad"></span>
                            <button type="button" @click="cantidad++"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">+</button>
                        </div>

                        <form action="" method="POST" class="flex-1">
                            @csrf
                            <button
                                type="button"
                                class="add-to-cart w-full flex items-center justify-center gap-2 bg-orange-500 text-white font-semibold py-2 rounded-full text-xs hover:bg-orange-600 transition duration-300 shadow"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio_descuento ?? $producto->precio }}"
                                data-imagen="{{ asset($producto->imagen_principal) }}"
                                data-categoria="{{ $producto->categoria_id }}"

                                x-bind:data-talla="tallaSeleccionada ?? ''"
                                x-bind:data-cantidad="cantidad">
                                <i class="fas fa-shopping-cart text-xs"></i>
                                Agregar
                            </button>

                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>






<section class="bg-gradient-to-r from-orange-400 to-red-500 py-10 text-white">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
            🎉 ¡Descuento para usuarios nuevos!
        </h2>
        <p class="mt-4 text-lg md:text-xl font-medium">
            Obtén un <span class="font-bold text-yellow-300">25% de descuento</span> en tu primera compra. Solo por tiempo limitado.
        </p>
        <!-- <div class="mt-6">
            <a href="#productos-container" class="inline-block bg-white text-orange-600 font-semibold py-3 px-6 rounded-full shadow-lg hover:bg-gray-100 transition duration-300">
                Comprar ahora
            </a>
        </div> -->
    </div>
</section>



<section class="init1 bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800">Para Hombre</h2>
            <p class="text-gray-500 mt-2">Diseños modernos y cómodos para ellos</p>
            <div class="w-20 h-1 bg-blue-600 mt-4 rounded-full mx-auto"></div>
        </div>

        @if($productosHombre->isEmpty())
        <p class="text-center text-gray-600 text-lg py-20">
            Por el momento no hay productos para hombre.
        </p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($productosHombre as $producto)
            <div
                x-data="{ tallaSeleccionada: null, cantidad: 1 }"
                class="bg-white rounded-3xl shadow-md hover:shadow-lg transition duration-300 flex flex-col overflow-hidden">
                <!-- Imagen -->
                <div class="relative bg-gray-50 h-[260px] flex items-center justify-center">
                    <img src="{{ asset($producto->imagen_principal) }}" alt="{{ $producto->nombre }}"
                        class="max-h-full max-w-[90%] object-contain transition-transform duration-300 hover:scale-105">
                    <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-xl z-10">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <!-- Contenido -->
                <div class="p-4 flex flex-col flex-grow space-y-4">
                    <!-- Nombre y descripción -->
                    <div class="text-left">
                        <h3 class="text-[15px] font-semibold text-gray-800 mb-1 break-words" title="{{ $producto->nombre }}">
                            {{ $producto->nombre }}
                        </h3>
                        <p class="text-xs text-gray-600 text-justify break-words leading-snug" title="{{ $producto->descripcion }}">
                            {{ $producto->descripcion }}
                        </p>
                    </div>

                    <!-- Precio -->
                    <div class="text-left">
                        @if($producto->precio_descuento)
                        <span class="text-red-500 text-xs line-through">S/ {{ number_format($producto->precio, 2) }}</span>
                        <span class="ml-2 text-blue-700 text-base font-bold">S/ {{ number_format($producto->precio_descuento, 2) }}</span>
                        @else
                        <span class="text-blue-700 text-base font-bold">S/ {{ number_format($producto->precio, 2) }}</span>
                        @endif
                    </div>

                    <!-- Tallas -->
                    @if($producto->tallas && count($producto->tallas))
                    <div>
                        <p class="text-xs font-medium text-gray-700 mb-1">Talla:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($producto->tallas as $talla)
                            <label
                                class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center cursor-pointer text-xs hover:bg-blue-100 transition"
                                :class="{ 'bg-blue-600 text-white border-blue-600': tallaSeleccionada === '{{ $talla->nombre }}' }">
                                <input type="radio"
                                    name="talla_{{ $producto->id }}"
                                    value="{{ $talla->nombre }}"
                                    x-model="tallaSeleccionada"
                                    class="sr-only">
                                {{ $talla->nombre }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Cantidad + Agregar -->
                    <div class="flex items-center justify-between gap-3">
                        <!-- Cantidad -->
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(cantidad > 1) cantidad--"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">-</button>
                            <span class="text-sm font-medium w-6 text-center" x-text="cantidad"></span>
                            <button type="button" @click="cantidad++"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">+</button>
                        </div>

                        <!-- Botón Agregar -->
                        <form action="" method="POST" class="flex-1">
                            @csrf
                            <button
                                type="button"
                                class="add-to-cart w-full flex items-center justify-center gap-2 bg-[#1D4ED8] text-white font-semibold py-2 rounded-full text-xs hover:bg-[#1E40AF] transition duration-300 shadow"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio_descuento ?? $producto->precio }}"
                                data-imagen="{{ asset($producto->imagen_principal) }}"
                                data-categoria="{{ $producto->categoria_id }}"

                                :data-talla="tallaSeleccionada"
                                :data-cantidad="cantidad">
                                <i class="fas fa-shopping-cart text-xs"></i>
                                Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>


<!-- SECCIÓN MUJER -->
<section class="init1 bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-800">Para Mujer</h2>
            <p class="text-gray-500 mt-2 text-lg">Moda, comodidad y elegancia para ellas</p>
            <div class="w-20 h-1 bg-pink-500 mt-4 rounded-full mx-auto"></div>
        </div>

        @if($productosMujer->isEmpty())
        <p class="text-center text-gray-600 text-lg py-20">
            Por el momento no hay productos para mujer.
        </p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($productosMujer as $producto)
            <div
                x-data="{ tallaSeleccionada: null, cantidad: 1 }"
                class="bg-white rounded-3xl shadow-md hover:shadow-lg transition duration-300 flex flex-col overflow-hidden">
                <!-- Imagen -->
                <div class="relative bg-gray-50 h-[260px] flex items-center justify-center">
                    <img src="{{ asset($producto->imagen_principal) }}" alt="{{ $producto->nombre }}"
                        class="max-h-full max-w-[90%] object-contain transition-transform duration-300 hover:scale-105">
                    <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-xl z-10">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <!-- Contenido -->
                <div class="p-4 flex flex-col flex-grow space-y-4">
                    <!-- Nombre y descripción -->
                    <div class="text-left">
                        <h3 class="text-[15px] font-semibold text-gray-800 mb-1 break-words" title="{{ $producto->nombre }}">
                            {{ $producto->nombre }}
                        </h3>
                        <p class="text-xs text-gray-600 text-justify break-words leading-snug" title="{{ $producto->descripcion }}">
                            {{ $producto->descripcion }}
                        </p>
                    </div>

                    <!-- Precio -->
                    <div class="text-left">
                        @if($producto->precio_descuento)
                        <span class="text-red-500 text-xs line-through">S/ {{ number_format($producto->precio, 2) }}</span>
                        <span class="ml-2 text-pink-600 text-base font-bold">S/ {{ number_format($producto->precio_descuento, 2) }}</span>
                        @else
                        <span class="text-gray-800 text-base font-bold">S/ {{ number_format($producto->precio, 2) }}</span>
                        @endif
                    </div>

                    <!-- Tallas -->
                    @if($producto->tallas && count($producto->tallas))
                    <div>
                        <p class="text-xs font-medium text-gray-700 mb-1">Talla:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($producto->tallas as $talla)
                            <label
                                class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center cursor-pointer text-xs hover:bg-pink-100 transition"
                                :class="{ 'bg-pink-600 text-white border-pink-600': tallaSeleccionada === '{{ $talla->nombre }}' }">
                                <input type="radio"
                                    name="talla_{{ $producto->id }}"
                                    value="{{ $talla->nombre }}"
                                    x-model="tallaSeleccionada"
                                    class="sr-only">
                                {{ $talla->nombre }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Cantidad + Botón -->
                    <div class="flex items-center justify-between gap-3">
                        <!-- Cantidad -->
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(cantidad > 1) cantidad--"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">-</button>
                            <span class="text-sm font-medium w-6 text-center" x-text="cantidad"></span>
                            <button type="button" @click="cantidad++"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">+</button>
                        </div>

                        <!-- Botón Agregar -->
                        <form action="" method="POST" class="flex-1">
                            @csrf
                            <button
                                type="button"
                                class="add-to-cart w-full flex items-center justify-center gap-2 bg-pink-600 text-white font-semibold py-2 rounded-full text-xs hover:bg-pink-700 transition duration-300 shadow"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio_descuento ?? $producto->precio }}"
                                data-imagen="{{ asset($producto->imagen_principal) }}"
                                data-categoria="{{ $producto->categoria_id }}"

                                :data-talla="tallaSeleccionada"
                                :data-cantidad="cantidad">
                                <i class="fas fa-shopping-cart text-xs"></i>
                                Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>




<!-- SECCIÓN ACESORIOS -->
<section class="init1 bg-gray-50 py-14">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-800">ACCESORIOS</h2>
            <p class="text-gray-500 mt-2 text-lg">Complementa tu estilo con los mejores accesorios para todos</p>
            <div class="w-20 h-1 bg-green-500 mt-4 rounded-full mx-auto"></div>
        </div>

        @if($productosAccesorios->isEmpty())
        <p class="text-center text-gray-600 text-lg py-20">
            Por el momento no hay accesorios disponibles.
        </p>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($productosAccesorios as $producto)
            <div
                x-data="{ tallaSeleccionada: null, cantidad: 1 }"
                class="bg-white rounded-3xl shadow-md hover:shadow-lg transition duration-300 flex flex-col overflow-hidden">
                <!-- Imagen -->
                <div class="relative bg-gray-50 h-[260px] flex items-center justify-center">
                    <img src="{{ asset($producto->imagen_principal) }}" alt="{{ $producto->nombre }}"
                        class="max-h-full max-w-[90%] object-contain transition-transform duration-300 hover:scale-105">
                    <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 text-xl z-10">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

                <!-- Contenido -->
                <div class="p-4 flex flex-col flex-grow space-y-4">
                    <!-- Nombre y descripción -->
                    <div class="text-left">
                        <h3 class="text-[15px] font-semibold text-gray-800 mb-1 break-words" title="{{ $producto->nombre }}">
                            {{ $producto->nombre }}
                        </h3>
                        <p class="text-xs text-gray-600 text-justify break-words leading-snug" title="{{ $producto->descripcion }}">
                            {{ $producto->descripcion }}
                        </p>
                    </div>

                    <!-- Precio -->
                    <div class="text-left">
                        @if($producto->precio_descuento)
                        <span class="text-red-500 text-xs line-through">S/ {{ number_format($producto->precio, 2) }}</span>
                        <span class="ml-2 text-green-600 text-base font-bold">S/ {{ number_format($producto->precio_descuento, 2) }}</span>
                        @else
                        <span class="text-gray-800 text-base font-bold">S/ {{ number_format($producto->precio, 2) }}</span>
                        @endif
                    </div>

                    <!-- Tallas (si existen) -->
                    @if($producto->tallas && count($producto->tallas))
                    <div>
                        <p class="text-xs font-medium text-gray-700 mb-1">Talla:</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($producto->tallas as $talla)
                            <label
                                class="w-8 h-8 border border-gray-300 rounded-full flex items-center justify-center cursor-pointer text-xs hover:bg-blue-100 transition"
                                :class="{ 'bg-blue-600 text-white border-blue-600': tallaSeleccionada === '{{ $talla->nombre }}' }">
                                <input type="radio"
                                    name="talla_{{ $producto->id }}"
                                    value="{{ $talla->nombre }}"
                                    x-model="tallaSeleccionada"
                                    class="sr-only">
                                {{ $talla->nombre }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Cantidad + Agregar -->
                    <div class="flex items-center justify-between gap-3">
                        <!-- Cantidad -->
                        <div class="flex items-center gap-2">
                            <button type="button" @click="if(cantidad > 1) cantidad--"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">-</button>
                            <span class="text-sm font-medium w-6 text-center" x-text="cantidad"></span>
                            <button type="button" @click="cantidad++"
                                class="w-8 h-8 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 font-bold text-sm">+</button>
                        </div>

                        <!-- Botón Agregar -->
                        <form action="" method="POST" class="flex-1">
                            @csrf
                            <button
                                type="button"
                                class="add-to-cart w-full flex items-center justify-center gap-2 bg-[#198754] text-white font-semibold py-2 rounded-full text-xs hover:bg-[#146c43] transition duration-300 shadow"
                                data-id="{{ $producto->id }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio_descuento ?? $producto->precio }}"
                                data-imagen="{{ asset($producto->imagen_principal) }}"
                                data-categoria="{{ $producto->categoria_id }}"

                                :data-talla="tallaSeleccionada"
                                :data-cantidad="cantidad"
                                :disabled="false">
                                <i class="fas fa-shopping-cart text-xs"></i>
                                Agregar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>



<div class="popup-overlay" id="popupOverlay">
    <div class="popup" id="popup">
        <div class="left"></div>
        <div class="flex-1 p-5 relative">
            <button class="absolute top-3 right-3 text-gray-500 hover:text-red-500 transition duration-300" onclick="closePopup()" aria-label="Cerrar">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-2xl font-semibold mb-4 text-center">¡Suscríbete para recibir ofertas!</h2>

            <!-- Pregunta para elegir el método de contacto -->
            <div class="mb-4">
                <p class="text-lg font-medium text-gray-700">¿Cómo deseas recibir las ofertas?</p>
                <div class="flex items-center space-x-4 mt-3">
                    <label class="flex items-center">
                        <input type="radio" id="porCorreo" name="metodo" class="mr-2" onclick="toggleFields()"> Correo
                    </label>
                    <label class="flex items-center">
                        <input type="radio" id="porWhatsApp" name="metodo" class="mr-2" onclick="toggleFields()"> WhatsApp
                    </label>
                </div>
            </div>

            <!-- Campo de nombre (siempre visible) -->
            <input type="text" placeholder="Nombre" id="nombre" class="w-full mb-3 p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none" />

            <!-- Campo de correo (solo visible si se selecciona correo) -->
            <div id="emailField" class="hidden">
                <input type="email" placeholder="Correo electrónico" id="correo" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none" />
            </div>

            <!-- Campo de WhatsApp (solo visible si se selecciona WhatsApp) -->
            <div id="whatsappField" class="hidden">
                <input id="telefono" type="tel" class="w-full mb-3 p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none" placeholder="Tu número de WhatsApp" />
            </div>

            <!-- Campo de interés -->
            <textarea placeholder="Productos de tu interés" class="w-full mt-3 mb-5 p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none" rows="2"></textarea>



            <!-- Botón de suscripción -->
            <button id="btnSuscribirse" type="button" class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 transition">
                Suscribirse
            </button>
        </div>
    </div>
</div>


<div class="fixed bottom-4 right-6 z-10">
    <button
        onclick="showPopup()"
        class="group flex items-center bg-gradient-to-r from-orange-700 to-orange-600 hover:from-orange-600 hover:to-orange-500 text-white h-14 rounded-full shadow-2xl transition-all duration-300 ease-in-out pl-4 pr-3 overflow-hidden relative"
        style="width: 56px;"
        onmouseenter="expandBtn(this)"
        onmouseleave="shrinkBtn(this)">
        <!-- Texto oculto inicialmente -->
        <span class="text-sm font-semibold whitespace-nowrap max-w-0 overflow-hidden transition-[max-width,opacity,padding] duration-400 ease-in-out opacity-0 group-hover:max-w-xs group-hover:opacity-100 group-hover:pr-3">
            Suscripcion
        </span>

        <!-- Ícono que siempre se mantiene en el extremo derecho -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 flex-shrink-0 ml-auto z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0-4v6a2 2 0 01-2 2H9.5a1.5 1.5 0 010-3H11m4-5V5a2 2 0 00-2-2H5.5A1.5 1.5 0 004 4.5v8A1.5 1.5 0 005.5 14H11a2 2 0 002-2v-2" />
        </svg>
    </button>
</div>

<script>
    function expandBtn(btn) {
        btn.style.width = '160px';
    }

    function shrinkBtn(btn) {
        btn.style.width = '56px';
    }

    function showPopup() {
        // Aquí muestra tu popup o realiza la acción
        console.log("Botón clickeado");
    }
</script>


<!-- Botón flotante para chat -->
<div class="fixed bottom-20 right-6 z-10">
    <button
        id="chatbotBtn"
        onclick="openChatbot()"
        title="Soporte en línea"
        class="group flex items-center bg-gradient-to-r from-blue-700 to-blue-600 hover:from-blue-600 hover:to-blue-500 text-white h-14 rounded-full shadow-2xl transition-all duration-300 ease-in-out pl-4 pr-3 overflow-hidden relative"
        style="backdrop-filter: saturate(180%) blur(8px);">
        <span class="text-sm font-semibold whitespace-nowrap max-w-0 overflow-hidden transition-[max-width,opacity,padding] duration-400 ease-in-out opacity-0 group-hover:max-w-xs group-hover:opacity-100 group-hover:pr-3">
            Chat en vivo
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
        </svg>
    </button>
</div>




<script>
    let iti;

    function toggleFields() {
        const porCorreo = document.getElementById("porCorreo").checked;
        const porWhatsApp = document.getElementById("porWhatsApp").checked;

        const emailField = document.getElementById("emailField");
        const whatsappField = document.getElementById("whatsappField");

        if (porCorreo) {
            emailField.classList.remove("hidden");
            whatsappField.classList.add("hidden");
            document.getElementById("correo").value = "";
            if (iti) iti.setNumber("");
        } else if (porWhatsApp) {
            whatsappField.classList.remove("hidden");
            emailField.classList.add("hidden");
            document.getElementById("correo").value = "";
            if (iti) iti.setNumber("");
        } else {
            emailField.classList.add("hidden");
            whatsappField.classList.add("hidden");
            document.getElementById("correo").value = "";
            if (iti) iti.setNumber("");
        }
    }

    document.getElementById("btnSuscribirse").addEventListener("click", async () => {
        const nombre = document.getElementById("nombre").value.trim();
        const interes = document.querySelector("textarea").value.trim();
        const porCorreo = document.getElementById("porCorreo").checked;
        const porWhatsApp = document.getElementById("porWhatsApp").checked;

        if (!porCorreo && !porWhatsApp) {
            alert("Por favor, selecciona cómo deseas recibir las promociones.");
            return;
        }

        if (!nombre) {
            alert("Por favor, ingresa tu nombre.");
            return;
        }

        const datos = {
            nombre,
            interes: interes || null,
            correo: null,
            telefono: null,
        };

        if (porCorreo) {
            const correo = document.getElementById("correo").value.trim();
            if (!correo) {
                alert("Por favor, ingresa tu correo electrónico.");
                return;
            }
            datos.correo = correo;
        }

        if (porWhatsApp) {
            const telefono = iti.getNumber();
            if (!iti.isValidNumber()) {
                alert("Por favor, ingresa un número de WhatsApp válido.");
                return;
            }
            datos.telefono = telefono;
        }

        try {
            const response = await fetch("/suscribirse", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (!response.ok) {
                const errorMsg = resultado.message || "Error al procesar la suscripción.";
                console.error("Error del servidor:", resultado);
                alert("Error: " + errorMsg);
                return;
            }

            alert("¡Gracias por suscribirte!");
            closePopup();

            // Limpiar el formulario
            document.getElementById("nombre").value = "";
            document.getElementById("correo").value = "";
            if (iti) iti.setNumber("");
            document.querySelector("textarea").value = "";
            document.getElementById("porCorreo").checked = false;
            document.getElementById("porWhatsApp").checked = false;
            toggleFields();

        } catch (error) {
            console.error("Error de red o JS:", error);
            alert("Hubo un problema al enviar tu suscripción. Inténtalo más tarde.");
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        toggleFields();

        const input = document.getElementById("telefono");
        iti = window.intlTelInput(input, {
            initialCountry: "auto",
            nationalMode: false,
            preferredCountries: ["pe", "mx", "ar", "cl", "co"],
            geoIpLookup: function(callback) {
                fetch("https://ipinfo.io/json?token=7178f361103b77")
                    .then((res) => res.json())
                    .then((data) => callback(data.country))
                    .catch(() => callback("us"));
            },
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17.0.19/build/js/utils.js",
        });
    });
</script>

<script>
    const popupOverlay = document.getElementById('popupOverlay');
    const popup = document.getElementById('popup');
    const floatingBtn = document.getElementById('floatingBtn');

    function showPopup() {
        popup.classList.remove('fadeOut');
        popupOverlay.style.display = 'flex';
        floatingBtn.style.display = 'block';
    }

    function closePopup() {
        popup.classList.add('fadeOut');
        setTimeout(() => {
            popupOverlay.style.display = 'none';
            floatingBtn.style.display = 'block';
        }, 500);
    }

    window.addEventListener('load', () => {
        if (!sessionStorage.getItem('popupShown')) {
            popupOverlay.style.display = 'flex';
            sessionStorage.setItem('popupShown', 'true');
        }

        const input = document.querySelector("#telefono");

        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            separateDialCode: false, // ✅ No separamos código para que no distorsione
            geoIpLookup: function(success, failure) {
                fetch("https://ipinfo.io?token=7178f361103b77")
                    .then(resp => resp.json())
                    .then(resp => success(resp.country))
                    .catch(() => success("us"));
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
        });

        // Estilo opcional para que la bandera se vea bien alineada y limpia
        const style = document.createElement('style');
        style.innerHTML = `
      .iti {
        width: 100%;
      }
      .iti__flag-container {
        margin-right: 8px;
      }
      .iti__selected-flag {
        width: 46px !important; /* espacio solo para bandera */
      }
    `;
        document.head.appendChild(style);

    });
</script>




<script>
    // Obtener el carrito desde localStorage, o usar un carrito vacío si no existe
    let carter = JSON.parse(localStorage.getItem('carrito')) || [];

    // Función para renderizar el carrito
    function renderCarter() {
        const cartContainer = document.getElementById('cartItems');
        const emptyMessage = document.getElementById('emptyCartMessage');
        const totalContainer = document.getElementById('totalAmount');
        const countContainer = document.getElementById('cartCount');

        cartContainer.innerHTML = ''; // Limpiar carrito
        let total = 0;
        let totalItems = 0;

        if (carter.length === 0) {
            emptyMessage.classList.remove('hidden');
        } else {
            emptyMessage.classList.add('hidden');
            carter.forEach((item, index) => {
                total += item.precio * item.cantidad;
                totalItems += item.cantidad;

                // Mostrar los productos del carrito
                cartContainer.innerHTML += `
                    <div class="flex items-center justify-between border-b py-3">
                        <div class="flex gap-3">
                            <img src="${item.imagen}" class="w-14 h-14 object-cover rounded-md" alt="${item.nombre}">
                            <div>
                                <p class="font-medium text-sm">${item.nombre}</p>
                                <p class="text-xs text-gray-500">
                                    ${item.cantidad} x S/ ${item.precio.toFixed(2)}<br>
                                    <span class="text-[11px] text-gray-400">Talla: ${item.talla}</span>
                                </p>

                            </div>
                        </div>
                        <button onclick="removeFromCart(${index})" class="text-red-500 text-sm hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            });
        }

        totalContainer.textContent = `S/ ${total.toFixed(2)}`;
        countContainer.textContent = totalItems;

        // Guardar el carrito en localStorage
        localStorage.setItem('carrito', JSON.stringify(carter));
    }



    function actualizarBotonesEstado() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            const id = button.dataset.id;

            const existe = carter.some(item => String(item.id) === String(id));

            if (existe) {
                button.classList.add('agregado', 'ring-2', 'ring-green-400', 'bg-green-100', 'text-green-800');
                button.classList.remove('hover:bg-orange-600', 'text-white');
            } else {
                button.classList.remove('agregado', 'ring-2', 'ring-green-400', 'bg-green-100', 'text-green-800');
                button.classList.add('hover:bg-orange-600', 'text-white');
            }
        });
    }


    // Función para eliminar un producto del carrito
    function removeFromCart(index) {
        carter.splice(index, 1);
        localStorage.setItem('carrito', JSON.stringify(carter));
        renderCarter();

        setTimeout(() => {
            actualizarBotonesEstado();
            document.querySelectorAll('[x-data]').forEach(component => {
                component.__x.$data.tallaSeleccionada = null;
                component.__x.$data.cantidad = 1;
            });
        }, 200);
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const precio = parseFloat(this.getAttribute('data-precio'));
            const imagen = this.getAttribute('data-imagen');
            const talla = this.getAttribute('data-talla');
            const cantidad = parseInt(this.getAttribute('data-cantidad'));
            const categoriaId = parseInt(this.getAttribute('data-categoria'));

            // Validar talla si no es accesorio
            if ((!talla || talla === 'null') && categoriaId !== 3) {
                Toastify({
                    text: "⚠️ Por favor, selecciona una talla antes de continuar.",
                    duration: 3500,
                    gravity: "bottom",
                    position: "left",
                    close: true,
                    style: {
                        background: "linear-gradient(to right, #dc2626, #b91c1c)",
                        color: "#fff",
                        borderRadius: "8px",
                        fontWeight: "500",
                        fontSize: "14px",
                        padding: "12px 20px",
                        boxShadow: "0 4px 8px rgba(0, 0, 0, 0.15)",
                    },
                    stopOnFocus: true
                }).showToast();

                return;
            }

            const existente = carter.find(item =>
                String(item.id) === String(id) &&
                String(item.talla || '') === String(talla || '')
            );



            if (existente) {
                existente.cantidad += cantidad;
            } else {
                carter.push({
                    id,
                    nombre,
                    precio,
                    imagen,
                    talla,
                    cantidad
                });
            }

            localStorage.setItem('carrito', JSON.stringify(carter));

            Toastify({
                text: "✅ Producto agregado correctamente al carrito.",
                duration: 3000,
                gravity: "bottom",
                position: "left",
                close: true,
                style: {
                    background: "linear-gradient(to right, #16a34a, #15803d)",
                    color: "#ffffff",
                    borderRadius: "8px",
                    fontWeight: "500",
                    fontSize: "14px",
                    padding: "12px 20px",
                    boxShadow: "0 4px 10px rgba(0, 0, 0, 0.15)",
                },
                stopOnFocus: true
            }).showToast();

            renderCarter();
            actualizarBotonesEstado();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        renderCarter();

        // Esperar a que Alpine reactive los atributos dinámicos (como data-talla)
        setTimeout(() => {
            actualizarBotonesEstado();
        }, 100); // o 200 ms si Alpine carga lento
    });





    // Función para limpiar el carrito
    function limpiarCarrito() {
        carter = []; // Limpiar el carrito
        localStorage.setItem('carter', JSON.stringify(carter)); // Eliminar del localStorage
        renderCarter(); // Actualizar la interfaz
    }

    // Función para generar la factura
    function generarFactura() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        let total = 0;
        let y = 20;

        // Usamos el carrito de compras almacenado en localStorage
        const cartItems = [...carter]; // Copia de los productos del carrito

        // Configuración de la fuente para una mejor legibilidad
        doc.setFont("helvetica", "normal");

        //LOGOGOGOGOGOGO POR PONER
        const logo = '';
        doc.addImage(logo, 'PNG', 20, y, 40, 20); // Ajusta las coordenadas y tamaño del logo
        y += 25; // Ajusta el espacio después del logo

        // Encabezado con el nombre de la tienda
        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text("Cotizacion de Compra", 75, y); // Centrado a la derecha
        y += 10;

        // Datos del cliente
        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text("Cliente: Juan Pérez", 20, y);
        y += 6;
        doc.text("Dirección: Calle Ficticia 123, Lima", 20, y);
        y += 12;

        // Detalle de la compra
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text("Detalles de la compra:", 20, y);
        y += 10;

        // Tabla de productos con líneas y bordes
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");

        // Títulos de columna con un diseño profesional
        doc.setFillColor(50, 50, 50); // Color de fondo para la cabecera
        doc.rect(20, y, 60, 8, 'F'); // Rectángulo con fondo gris para "Producto"
        doc.rect(80, y, 40, 8, 'F'); // Rectángulo con fondo gris para "Cantidad"
        doc.rect(120, y, 60, 8, 'F'); // Rectángulo con fondo gris para "Precio"

        doc.setTextColor(255, 255, 255); // Texto blanco
        doc.text("Producto", 22, y + 5);
        doc.text("Cantidad", 85, y + 5);
        doc.text("Precio", 135, y + 5);

        y += 10; // Avanzamos a la siguiente fila

        // Línea de separación
        doc.setTextColor(0, 0, 0); // Regresamos al color negro para el texto
        doc.line(20, y, 190, y); // Línea de separación entre títulos y datos
        y += 5;

        // Lista de productos
        cartItems.forEach(item => {
            doc.text(item.nombre, 20, y);
            doc.text(item.cantidad.toString(), 85, y);
            doc.text(`S/ ${(item.precio).toFixed(2)}`, 135, y);
            y += 10;
            total += item.cantidad * item.precio;
        });

        // Línea de separación antes del total
        y += 10;
        doc.line(20, y, 190, y); // Línea de separación entre productos y total
        y += 5;

        // Total
        doc.setFontSize(12);
        doc.setFont("helvetica", "bold");
        doc.text(`Total: S/ ${total.toFixed(2)}`, 140, y);

        // Footer con información adicional
        y += 20;
        doc.setFontSize(10);
        doc.setFont("helvetica", "normal");
        doc.text("Gracias por tu compra. Para consultas, contáctanos al: ventas@tienda.com", 20, y);

        // Guardar como PDF
        doc.save("factura.pdf");

        // Prepara mensaje para WhatsApp
        let mensaje = "Hola, adjunto mi pedido:\n";
        cartItems.forEach(item => {
            mensaje += `• ${item.cantidad}x ${item.nombre} - S/ ${(item.cantidad * item.precio).toFixed(2)}\n`;
        });
        mensaje += `\nTotal: S/ ${total.toFixed(2)}\n\nGracias por tu compra.`;

        // Abre WhatsApp con el mensaje
        const numero = "51950774325"; // Reemplaza con el número del vendedor
        const url = `https://wa.me/${numero}?text=${encodeURIComponent(mensaje)}`;
        window.open(url, '_blank');
    }

    // Función para proceder con el pago y limpiar los campos
    function procederPago() {
        // generarFactura();

        const destino = "{{ route('vistapublica.procesocarrito') }}";
        if (window.location.pathname !== new URL(destino, window.location.origin).pathname) {
            window.location.href = destino;
            // limpiarCarrito();
        } else {
            console.log("Ya estás en la página de proceso carrito");
        }
    }


    document.getElementById('generateInvoiceBtn').addEventListener('click', function(event) {
        event.preventDefault();
        console.log("Botón clickeado");

        if (!isLoggedIn) {
            console.log("No está logueado");
            Swal.fire({
                icon: 'warning',
                title: '¡Necesitas iniciar sesión!',
                text: 'Para continuar con tu compra, inicia sesión con tu cuenta.',
                showCloseButton: true,
                confirmButtonText: 'Iniciar sesión',
                confirmButtonColor: '#f97316',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    const redirectAfterLogin = encodeURIComponent("{{ route('vistapublica.procesocarrito') }}");
                    window.location.href = "{{ route('vistapublica.iniciarsession') }}?returnTo=" + redirectAfterLogin;
                }
            });
            return;
        }

        console.log("Está logueado");
        procederPago(); // Aquí sigue el flujo normal
    });
</script>

<style>
    .add-to-cart.agregado {
        background-color: #bbf7d0 !important;
        /* bg-green-100 */
        color: #166534 !important;

    }

    .add-to-cart.agregado:hover {
        background-color: #bbf7d0 !important;
        /* bg-green-100 */
        color: #166534 !important;
        /* text-green-800 */
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- Toast Favoritos -->
<div id="toast-favorito"
    class="fixed bottom-6 left-6 bg-amber-300 text-gray-800 px-5 py-3 rounded-xl shadow-lg border border-orange-300 text-sm hidden z-50 transition-all duration-300 font-medium">
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toast = document.getElementById('toast-favorito');
        const botones = document.querySelectorAll('.btn-favorito');

        let toastTimeout1, toastTimeout2;

        function mostrarToast(mensaje) {
            clearTimeout(toastTimeout1);
            clearTimeout(toastTimeout2);

            toast.textContent = mensaje;
            toast.classList.remove('hidden', 'animate-slide-in', 'animate-slide-out');
            toast.classList.add('animate-slide-in');

            toastTimeout1 = setTimeout(() => {
                toast.classList.remove('animate-slide-in');
                toast.classList.add('animate-slide-out');
                toastTimeout2 = setTimeout(() => {
                    toast.classList.remove('animate-slide-out');
                    toast.classList.add('hidden');
                }, 300);
            }, 2500);
        }

        botones.forEach(btn => {
            const icon = btn.querySelector('i');

            btn.addEventListener('click', () => {
                if (btn.disabled) return;
                btn.disabled = true;

                const productoId = btn.dataset.id;

                fetch('/favorito/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            producto_id: productoId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'agregado') {
                            icon.classList.remove('far', 'text-gray-400');
                            icon.classList.add('fas', 'text-red-500');
                            mostrarToast('Producto agregado a favoritos');
                        } else {
                            icon.classList.remove('fas', 'text-red-500');
                            icon.classList.add('far', 'text-gray-400');
                            mostrarToast('Producto eliminado de favoritos');
                        }

                        setTimeout(() => {
                            btn.disabled = false;
                        }, 800);
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        mostrarToast('Error al actualizar favoritos');
                        btn.disabled = false;
                    });
            });
        });
    });
</script>





<!-- Animaciones opcionales (Tailwind compatible) -->
<style>
    .animate-slide-in {
        animation: slideIn 0.3s ease-out forwards;
    }

    .animate-slide-out {
        animation: slideOut 0.3s ease-in forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateY(30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateY(0);
            opacity: 1;
        }

        to {
            transform: translateY(30px);
            opacity: 0;
        }
    }
</style>





@endsection