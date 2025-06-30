@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-10 flex gap-8 bg-white-50">
    <!-- ASIDE DE FILTROS -->
    <!-- ASIDE DE FILTROS -->
    <aside class="w-64 bg-white border border-gray-200 rounded-lg p-5 sticky top-4 space-y-6">
        <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Filtrar productos</h2>


        <!-- Tipo de producto -->
        <div class="filtro" data-filtro="tipo">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Tipo de producto</h3>
            <div class="space-y-1">
                @foreach(['Polos', 'Poleras', 'Zapatillas'] as $tipo)
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" value="{{ $tipo }}" class="accent-blue-600 filtro-checkbox"> {{ $tipo }}
                </label>
                @endforeach
            </div>
        </div>
        <hr class="border-t border-gray-200">

        <!-- Talla -->
        <div class="filtro" data-filtro="talla">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Talla</h3>
            <div class="flex flex-wrap gap-2">
                @foreach(['S', 'M', 'L', '36', '37', '38', '39', '40', '41', '42'] as $talla)
                <label class="w-9 h-9 flex items-center justify-center border rounded-full cursor-pointer text-sm text-gray-600 hover:bg-blue-600 hover:text-white transition">
                    <input type="checkbox" value="{{ $talla }}" class="sr-only filtro-checkbox"> {{ $talla }}
                </label>
                @endforeach
            </div>
        </div>
        <hr class="border-t border-gray-200">

        <!-- Rango de precio con barra -->
        <div class="filtro-precio">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Rango de Precio (S/)</h3>
            <div class="flex flex-col gap-2">
                <input type="range" id="rangoPrecio" min="0" max="500" step="10" value="500" class="w-full accent-blue-600">
                <div class="flex justify-between text-sm text-gray-600">
                    <span>0</span>
                    <span id="precioSeleccionado">Hasta S/ 500</span>
                </div>
            </div>
        </div>
        <hr class="border-t border-gray-200">

        <!-- Disponibilidad -->
        <div class="filtro" data-filtro="disponibilidad">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Disponibilidad</h3>
            <div class="space-y-1">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" value="Disponible" class="accent-blue-600 filtro-checkbox"> Disponible
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" value="No disponible" class="accent-blue-600 filtro-checkbox"> No disponible
                </label>
            </div>
        </div>
        <hr class="border-t border-gray-200">


    </aside>


    <!-- SECCIÓN DE PRODUCTOS -->
    <section class="flex-1">
        <div class="mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 relative inline-block">
                FOR MEN
                <span class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-md"></span>
            </h1>
        </div>

        <div id="productosGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($productos as $producto)
            <div
                class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden producto-card relative p-4 flex flex-col space-y-3"
                data-marca="{{ $producto->marca->nombre ?? '' }}"
                data-tipo="{{ $producto->tipo->nombre ?? '' }}"
                data-color="{{ $producto->color ?? '' }}"
                data-talla="{{ $producto->talla ?? '' }}"
                data-disponibilidad="{{ $producto->stock > 0 ? 'Disponible' : 'No disponible' }}">
                <!-- Imagen del producto con efecto hover -->
                <div class="w-full h-[300px] overflow-hidden rounded-xl border border-gray-100 bg-white flex items-center justify-center group">
                    <img
                        src="{{ $producto->imagen_principal ? asset($producto->imagen_principal) : 'https://via.placeholder.com/300x200' }}"
                        alt="{{ $producto->nombre }}"
                        class="max-w-full max-h-full object-contain transition-transform duration-300 group-hover:scale-110">
                </div>


                <!-- Información -->
                <div class="flex flex-col space-y-1">
                    <h3 class="text-base font-semibold text-gray-800 truncate">{{ $producto->nombre }}</h3>
                    <p class="text-sm text-gray-500">{{ $producto->descripcion_corta }}</p>
                    <span class="text-blue-600 font-bold text-lg">S/ {{ number_format($producto->precio_descuento ?? $producto->precio, 2) }}</span>
                </div>

                <!-- Tallas -->
                @php $tipo = strtolower($producto->tipo->nombre ?? ''); @endphp
                <div>
                    <p class="text-xs text-gray-500 mb-1">Talla:</p>
                    <div class="flex flex-wrap gap-2">
                        @if($tipo === 'zapatillas')
                        @foreach(range(36, 42) as $talla)
                        <label class="w-8 h-8 flex items-center justify-center border rounded-full cursor-pointer text-xs text-gray-600 hover:bg-blue-600 hover:text-white transition">
                            <input type="radio" name="talla_{{ $producto->id }}" value="{{ $talla }}" class="sr-only">
                            {{ $talla }}
                        </label>
                        @endforeach
                        @else
                        @foreach(['S', 'M', 'L'] as $talla)
                        <label class="w-8 h-8 flex items-center justify-center border rounded-full cursor-pointer text-xs text-gray-600 hover:bg-blue-600 hover:text-white transition">
                            <input type="radio" name="talla_{{ $producto->id }}" value="{{ $talla }}" class="sr-only">
                            {{ $talla }}
                        </label>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Cantidad + Botón Agregar -->
                <div class="flex items-center justify-between mt-2">
                    <!-- Selector de cantidad -->
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 text-lg font-bold" onclick="this.nextElementSibling.stepDown()">−</button>
                        <input type="number" min="1" value="1" class="w-10 text-center text-sm border-0 focus:ring-0" readonly>
                        <button type="button" class="px-3 py-1 text-gray-700 hover:bg-gray-100 text-lg font-bold" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>

                    <!-- Botón Agregar -->
                    <button class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-2 rounded-full shadow-md hover:from-blue-700 hover:to-blue-600 transition text-sm font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 7h13a1 1 0 0 0 1-1.2L19 13M7 13L5.4 5M10 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                        Agregar
                    </button>
                </div>
            </div>
            @endforeach

        </div>

        <div class="mt-10 flex justify-center space-x-2">
            {{ $productos->links() }}
        </div>
    </section>
</main>

<script>
    const slider = document.getElementById('rangoPrecio');
    const precioLabel = document.getElementById('precioSeleccionado');

    slider.addEventListener('input', () => {
        precioLabel.textContent = `Hasta S/ ${slider.value}`;
    });

    document.addEventListener('DOMContentLoaded', () => {
        const filtros = document.querySelectorAll('.filtro-checkbox');
        const productos = document.querySelectorAll('.producto-card');

        filtros.forEach(filtro => {
            filtro.addEventListener('change', () => {
                const filtrosActivos = {};

                document.querySelectorAll('.filtro').forEach(categoria => {
                    const key = categoria.dataset.filtro;
                    const checkboxes = categoria.querySelectorAll('input:checked');
                    filtrosActivos[key] = Array.from(checkboxes).map(cb => cb.value);
                });

                productos.forEach(producto => {
                    let visible = true;

                    for (const [clave, valores] of Object.entries(filtrosActivos)) {
                        if (valores.length === 0) continue;

                        const valorProducto = producto.dataset[clave];
                        if (!valores.includes(valorProducto)) {
                            visible = false;
                            break;
                        }
                    }

                    producto.style.display = visible ? 'block' : 'none';
                });
            });
        });
    });
</script>
@endsection