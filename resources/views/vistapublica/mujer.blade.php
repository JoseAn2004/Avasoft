@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<body class="bg-gray-50 font-sans">

    <main class="max-w-7xl mx-auto px-4 py-10 flex gap-8">
        <!-- ASIDE DE FILTROS -->
        <aside class="w-64 bg-white border border-gray-200 rounded-lg p-5 sticky top-4 space-y-6">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2">Filtrar productos</h2>

            <!-- Marca -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Marca</h3>
                <div class="space-y-1 filtro" data-filtro="marca">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Nike" class="accent-blue-600 filtro-checkbox"> Nike
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Adidas" class="accent-blue-600 filtro-checkbox"> Adidas
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Puma" class="accent-blue-600 filtro-checkbox"> Puma
                    </label>
                </div>
            </div>
            <hr class="border-t border-gray-200">

            <!-- Tipo de producto -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Tipo de producto</h3>
                <div class="space-y-1 filtro" data-filtro="tipo">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Zapatillas" class="accent-blue-600 filtro-checkbox"> Zapatillas
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Polos" class="accent-blue-600 filtro-checkbox"> Polos
                    </label>
                </div>
            </div>
            <hr class="border-t border-gray-200">

            <!-- Color -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Color</h3>
                <div class="space-y-1 filtro" data-filtro="color">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Negro" class="accent-blue-600 filtro-checkbox"> Negro
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Blanco" class="accent-blue-600 filtro-checkbox"> Blanco
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Azul" class="accent-blue-600 filtro-checkbox"> Azul
                    </label>
                </div>
            </div>
            <hr class="border-t border-gray-200">

            <!-- Talla -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Talla</h3>
                <div class="space-y-1 filtro" data-filtro="talla">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="S" class="accent-blue-600 filtro-checkbox"> S
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="M" class="accent-blue-600 filtro-checkbox"> M
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="L" class="accent-blue-600 filtro-checkbox"> L
                    </label>
                </div>
            </div>
            <hr class="border-t border-gray-200">

            <!-- Disponibilidad -->
            <div>
                <h3 class="text-sm font-medium text-gray-700 mb-2">Disponibilidad</h3>
                <div class="space-y-1 filtro" data-filtro="disponibilidad">
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="Disponible" class="accent-blue-600 filtro-checkbox"> Disponible
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox" value="No disponible" class="accent-blue-600 filtro-checkbox"> No disponible
                    </label>
                </div>
            </div>
        </aside>

        <!-- SECCIÓN DE PRODUCTOS -->
        <section class="flex-1">
            <!-- Título principal -->
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-gray-900 relative inline-block">
                    FOR WOMEN
                    <span class="absolute left-0 bottom-0 w-full h-1 bg-blue-600 rounded-md"></span>
                </h1>
            </div>

            <!-- Grid de productos -->
            <div id="productosGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($productos as $producto)
                    <div 
                        id="producto-{{ $producto->id }}"
                        class="bg-white p-4 rounded-lg border border-gray-200 hover:shadow-md transition producto-card"
                        data-marca="{{ $producto->marca->nombre ?? '' }}"
                        data-tipo="{{ $producto->tipo_producto_id ?? '' }}"
                        data-color="{{ $producto->color ?? '' }}"
                        data-talla="{{ $producto->talla ?? '' }}"
                        data-disponibilidad="{{ $producto->stock > 0 ? 'Disponible' : 'No disponible' }}"
                    >
                        <img 
                            src="{{ $producto->imagen_principal ? asset($producto->imagen_principal) : 'https://via.placeholder.com/300x200' }}" 
                            alt="{{ $producto->nombre }}" 
                            class="w-full h-48 object-cover rounded mb-4"
                        >
                        <h3 class="text-lg font-semibold text-gray-800">{{ $producto->nombre }}</h3>
                        <p class="text-sm text-gray-600">{{ $producto->descripcion_corta }}</p>
                        <span class="block mt-2 text-blue-600 font-bold">S/ {{ number_format($producto->precio_descuento ?? $producto->precio, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-10 flex justify-center space-x-2">
                {{ $productos->links() }}
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filtros = document.querySelectorAll('.filtro-checkbox');
            const productos = document.querySelectorAll('.producto-card');

            filtros.forEach(filtro => {
                filtro.addEventListener('change', () => {
                    // Recolectar filtros activos por categoría
                    const filtrosActivos = {};

                    document.querySelectorAll('.filtro').forEach(categoria => {
                        const filtroKey = categoria.dataset.filtro;
                        const checkboxes = categoria.querySelectorAll('input[type="checkbox"]:checked');
                        filtrosActivos[filtroKey] = Array.from(checkboxes).map(cb => cb.value);
                    });

                    productos.forEach(prod => {
                        let mostrar = true;
                        for (const [clave, valores] of Object.entries(filtrosActivos)) {
                            if (valores.length === 0) continue;

                            let valorProducto = prod.dataset[clave];

                            if (!valores.includes(valorProducto)) {
                                mostrar = false;
                                break;
                            }
                        }
                        prod.style.display = mostrar ? 'block' : 'none';
                    });
                });
            });
        });
    </script>

</body>
@endsection
