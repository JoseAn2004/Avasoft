@extends('layouts.adminpanel')
@section('content')
<div
  class="relative h-[calc(100vh-120px)] overflow-y-auto  p-8"
  x-data="productoManager()"
  x-init="init()">
  <!-- Encabezado -->
  <h1 class="text-white text-3xl font-bold mb-8 border-b-1 border-gray-200 pb-3 w-full">
    Productos
  </h1>

  <div class="flex justify-end my-4">
    <div class="flex flex-wrap gap-3">
      <!-- Botón Agregar Producto -->
      <button
        @click="openCreateModal"
        class="flex items-center gap-2 px-5 py-2.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 font-semibold text-sm rounded-sm transition-all duration-200">
        <!-- Icono: Plus -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Agregar Producto
      </button>

      <!-- Botón Exportar PDF -->
      <a href="{{ route('admin.productos.export.pdf') }}"
        class="flex items-center gap-2 px-5 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 font-semibold text-sm rounded-sm transition-all duration-200"
        target="_blank" rel="noopener noreferrer">
        <!-- Icono -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a2 2 0 002-2V6a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2m0 0v6a2 2 0 002 2h2a2 2 0 002-2v-6" />
        </svg>
        Exportar PDF
      </a>


      <!-- Botón Exportar Excel -->
      <a href="{{ route('admin.productos.export.excel') }}"
        class="flex items-center gap-2 px-5 py-2.5 bg-green-100 text-green-700 hover:bg-green-200 font-semibold text-sm rounded-sm transition-all duration-200">
        <!-- Icono: Table -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M10 14h10M4 18h10" />
        </svg>
        Exportar Excel
      </a>


      <!-- Botón Subir Excel 
      <label
        for="uploadExcel"
        class="flex items-center gap-2 px-5 py-2.5 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold text-sm rounded-sm transition-all duration-200 cursor-pointer">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4-4m0 0l-4 4m4-4v12" />
        </svg>
        Subir Excel
      </label>
      <input
        type="file"
        id="uploadExcel"
        @change="handleExcelUpload"
        accept=".xlsx, .xls"
        class="hidden" />-->
    </div>
  </div>



  <!-- Tabla de productos -->
  <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-indigo-200">
      <thead class="bg-indigo-100">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">#</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Imagen</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Nombre</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Descripción</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Tallas</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Precio</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Precio c/d</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Categoria</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Marca</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Tipo</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Stock</th>
          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Estado</th>

          <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-indigo-100">
        @foreach($productos as $producto)
        <tr class="border-b hover:bg-indigo-50">
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->id }}</td>
          <td class="px-6 py-4 text-sm text-gray-700" x-data="{ open: false }">

            <img
              src="{{ asset($producto->imagen_principal) }}"
              alt="Imagen del producto"
              class="w-16 h-16 object-cover rounded cursor-pointer"
              @click="open = true">
            <div
              x-show="open"
              x-cloak
              class="fixed inset-0 flex items-center justify-center bg-black/60 z-50"
              @click.away="open = false">
              <div class="bg-white p-4 rounded-lg shadow-lg max-w-xl w-full mx-4">
                <div class="flex justify-between items-center mb-4">
                  <h2 class="text-lg font-semibold">Imagen del Producto</h2>
                  <button @click="open = false" class="text-gray-600 hover:text-black text-xl">&times;</button>
                </div>
                <img
                  src="{{ asset($producto->imagen_principal) }}"
                  alt="Imagen ampliada"
                  class="w-full h-auto rounded">
              </div>
            </div>
          </td>

          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->nombre }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->descripcion_corta }}</td>
          <td class="px-6 py-4 text-sm text-gray-700 text-center align-middle">
            @if($producto->tallas && $producto->tallas->count())
            <div class="flex flex-col items-center justify-center space-y-1">
              @foreach($producto->tallas as $loopIndex => $talla)
              <div class="w-full text-gray-800 text-sm py-1">
                {{ $talla->nombre }}
              </div>
              @if(!$loop->last)
              <div class="w-3/4 border-b border-gray-300 opacity-30 mx-auto"></div>
              @endif
              @endforeach
            </div>
            @else
            <span class="text-gray-400 italic">Sin tallas</span>
            @endif
          </td>

          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->precio }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->precio_descuento }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->marca->nombre ?? 'Sin marca' }}</td>

          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->tipoProducto->nombre ?? 'Sin tipo' }}</td>

          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->stock }}</td>
          <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->estado }}</td>


          <td class="px-6 py-4 text-sm flex items-center">
            @php
            $jsonProducto = json_encode([
            'id' => $producto->id,
            'nombre' => $producto->nombre,
            'slug' => $producto->slug,
            'descripcion_corta' => $producto->descripcion_corta,
            'precio' => $producto->precio,
            'precio_descuento' => $producto->precio_descuento,
            'stock' => $producto->stock,
            'imagen_principal' => $producto->imagen_principal,
            'categoria_id' => $producto->categoria_id,
            'estado' => $producto->estado,
            'destacado' => $producto->destacado,
            'tipo_producto_id' => $producto->tipo_producto_id,
            'marca_id' => $producto->marca_id,
            'tallas' => $producto->tallas->pluck('id')->toArray(), // 👈 CLAVE

            ]);
            @endphp
            <button
              @click='openEditModal({{ $jsonProducto }})'
              class="p-2 bg-white text-yellow-500 border border-yellow-400 rounded-full shadow-sm hover:bg-yellow-50 hover:text-yellow-600 transition duration-200"
              title="Editar producto">
              <!-- Icono lápiz (lucide-edit) -->
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M11 5h2m1 0h1m-1 0l5 5m-1 0l-5-5m5 5L7 19H4v-3L16.5 5.5z" />
              </svg>
            </button>



            <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')">
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="p-2 ml-2 bg-white text-red-500 border border-red-400 rounded-full shadow-sm hover:bg-red-50 hover:text-red-600 transition duration-200"
                title="Eliminar producto">
                <!-- Icono papelera (lucide-trash) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7m2 0V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                </svg>
              </button>
            </form>


          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-6">{{ $productos->links() }}</div>

  <!-- Modal Crear Producto -->
  <div
    x-show="showCreate"
    x-transition
    x-cloak
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50 px-4">
    <div class="bg-white p-8 rounded-2xl w-full max-w-3xl shadow-2xl">
      <h3 class="text-3xl font-bold mb-3 text-gray-800 relative">
        Agregar Producto
        <span class="absolute left-0 bottom-[-16px] w-full border-b-2 border-gray-200"></span>
      </h3>

      <form
        action="{{ route('admin.productos.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5">
        @csrf

        <!-- Nombre -->
        <div class="relative">
          <input
            type="text"
            name="nombre"
            x-model="nombre"
            placeholder="Nombre del producto"
            class="w-full border-0 border-b-2 mt-9 border-gray-300 px-2 py-2 focus:outline-none focus:border-indigo-500 transition text-sm"
            required>
          <span x-show="tieneValor(nombre)" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500 font-bold">✓</span>
        </div>

        <div class="grid grid-cols-6 gap-4 items-end">
          <!-- Stock -->
          <div class="relative col-span-1">
            <input
              type="number"
              name="stock"
              x-model="stock"
              placeholder="Stock"
              step="1"
              min="1"
              oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '');"
              class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 focus:outline-none focus:border-indigo-500 transition text-sm"
              required>
            <span x-show="tieneValor(stock)" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500 font-bold">✓</span>
          </div>

          <!-- Precio -->
          <div class="relative col-span-1">
            <input
              type="number"
              name="precio"
              x-model.number="precio"
              placeholder="Precio"
              step="0.01"
              min="0"
              class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 focus:outline-none focus:border-indigo-500 transition text-sm"
              required>
            <span x-show="tieneValor(precio)" class="absolute right-3 top-1/2 -translate-y-1/2 text-green-500 font-bold">✓</span>
          </div>

          <!-- Checkbox y % -->
          <div class="col-span-4 flex items-center gap-4">
            <!-- Checkbox -->
            <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
              <input
                type="checkbox"
                x-model="aplicaDescuento"
                class="form-checkbox text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
              ¿Aplica descuento?
            </label>

            <!-- % descuento -->
            <div x-show="aplicaDescuento" x-cloak class="flex items-center gap-2">
              <div class="relative w-24">
                <input
                  type="number"
                  min="0"
                  max="100"
                  step="1"
                  x-model.number="porcentaje"
                  placeholder="0"
                  class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 pr-6 focus:outline-none focus:border-indigo-500 transition text-sm text-right">
                <span class="absolute right-1 top-1/2 -translate-y-1/2 text-gray-500 text-sm">%</span>
              </div>
            </div>


            <!-- Precio final -->
            <div>
              <input
                type="number"
                name="precio_descuento"
                :value="aplicaDescuento && precio && porcentaje
                ? (precio - (precio * porcentaje / 100)).toFixed(2)
                : (precio ? parseFloat(precio).toFixed(2) : '')"
                readonly
                placeholder="Precio final"
                class="w-full border-0 border-b-2 border-gray-300 bg-white text-gray-700 px-2 py-2 focus:outline-none focus:border-indigo-500 transition text-sm">
            </div>
          </div>
        </div>


        <div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

            <!-- Categoría -->
            <div class="relative">
              <label for="categoria_id" class="block text-sm text-gray-600 mb-1">Categoría</label>
              <select
                name="categoria_id"
                id="categoria_id"
                x-model="categoria"
                class="w-full bg-transparent border-0 border-b-2 border-gray-300 px-2 py-2 text-sm text-gray-900 focus:outline-none focus:border-indigo-500 transition"
                required>
                <option value="" disabled selected>Seleccione categoría</option>
                @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
              </select>
            </div>

            <!-- Tipo de producto -->
            <div class="relative">
              <label for="tipo_producto_id" class="block text-sm text-gray-600 mb-1">Tipo de producto</label>
              <select
                name="tipo_producto_id"
                id="tipo_producto_id"
                x-model="tipo_producto_id"
                @change="if (tipo_producto_id === 'nuevo') { showAddTipo = true; tipo_producto_id = ''; }"

                class="w-full bg-transparent border-0 border-b-2 border-gray-300 px-2 py-2 text-sm text-gray-900 focus:outline-none focus:border-indigo-500 transition"
                required>
                <option value="" disabled selected>Seleccione tipo</option>
                @foreach($tipoproducto as $tipos_producto)
                <option value="{{ $tipos_producto->id }}">{{ $tipos_producto->nombre }}</option>
                @endforeach
                <option value="nuevo">➕ Agregar nuevo tipo</option>
              </select>
            </div>


            <!-- Marca -->
            <div class="relative">
              <label for="marca_id" class="block text-sm text-gray-600 mb-1">Marca</label>
              <select
                name="marca_id"
                id="marca_id"
                x-model="marca_id"
                @change="if (marca_id === 'nueva') { showAddMarca = true; marca_id = ''; }"

                class="w-full bg-transparent border-0 border-b-2 border-gray-300 px-2 py-2 text-sm text-gray-900 focus:outline-none focus:border-indigo-500 transition"
                required>
                <option value="" disabled selected>Seleccione marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
                <option value="nueva">➕ Agregar nueva marca</option>
              </select>
            </div>

          </div>



          <div class="mt-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Selecciona tallas disponibles:</h4>
            <div class="flex justify-between items-start gap-6">

              <!-- Tallas de ropa -->
              <div class="flex flex-wrap gap-4 w-1/2 justify-start">
                <div class="w-full text-xs text-gray-500 mb-1 font-semibold">Tallas de ropa</div>
                @foreach($tallas as $talla)
                @if(!is_numeric($talla->nombre))
                <label class="flex items-center space-x-2">
                  <input
                    type="checkbox"
                    name="tallas[]"
                    value="{{ $talla->id }}"
                    class="form-checkbox text-indigo-600">
                  <span class="text-sm text-gray-800">{{ $talla->nombre }}</span>
                </label>
                @endif
                @endforeach
              </div>

              <!-- Línea divisora vertical -->
              <div class="w-px bg-gray-300 h-auto self-stretch"></div>

              <!-- Tallas de calzado -->
              <div class="flex flex-wrap gap-4 w-1/2 justify-start">
                <div class="w-full text-xs text-gray-500 mb-1 font-semibold">Tallas de calzado</div>
                @foreach($tallas as $talla)
                @if(is_numeric($talla->nombre))
                <label class="flex items-center space-x-2">
                  <input
                    type="checkbox"
                    name="tallas[]"
                    value="{{ $talla->id }}"
                    class="form-checkbox text-indigo-600">
                  <span class="text-sm text-gray-800">{{ $talla->nombre }}</span>
                </label>
                @endif
                @endforeach
              </div>

            </div>
          </div>







          <!-- MODAL: AGREGAR NUEVO TIPO -->
          <div x-show="showAddTipo" x-transition x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black/50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4 shadow-lg">
              <h2 class="text-lg font-semibold">Agregar nuevo tipo de producto</h2>
              <div class="space-y-2">
                <input x-model="nuevoTipo.nombre" type="text" placeholder="Nombre" class="w-full border rounded px-3 py-2 text-sm" />
                <textarea x-model="nuevoTipo.descripcion" placeholder="Descripción" class="w-full border rounded px-3 py-2 text-sm"></textarea>
                <input x-model="nuevoTipo.estado" type="text" placeholder="Estado" class="w-full border rounded px-3 py-2 text-sm" />
              </div>
              <div class="flex justify-end gap-2">
                <button @click="showAddTipo = false" class="px-4 py-2 bg-gray-200 rounded text-sm">Cancelar</button>
                <button @click="showAddTipo = false" class="px-4 py-2 bg-indigo-500 text-white rounded text-sm">Guardar</button>
              </div>
            </div>
          </div>

          <!-- MODAL: AGREGAR NUEVA MARCA -->
          <div x-show="showAddMarca" x-transition x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black/50">
            <div class="bg-white p-6 rounded-xl w-full max-w-md space-y-4 shadow-lg">
              <h2 class="text-lg font-semibold">Agregar nueva marca</h2>
              <div class="space-y-2">
                <input x-model="nuevaMarca.nombre" type="text" placeholder="Nombre" class="w-full border rounded px-3 py-2 text-sm" />
                <textarea x-model="nuevaMarca.descripcion" placeholder="Descripción" class="w-full border rounded px-3 py-2 text-sm"></textarea>
                <input x-model="nuevaMarca.estado" type="text" placeholder="Estado" class="w-full border rounded px-3 py-2 text-sm" />
              </div>
              <div class="flex justify-end gap-2">
                <button @click="showAddMarca = false" class="px-4 py-2 bg-gray-200 rounded text-sm">Cancelar</button>
                <button @click="showAddMarca = false" class="px-4 py-2 bg-indigo-500 text-white rounded text-sm">Guardar</button>
              </div>
            </div>
          </div>
        </div>




        <!-- Imagen -->
        <div class="relative">
          <input
            type="file"
            name="imagen_principal"
            accept="image/*"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 focus:outline-none focus:border-indigo-500 transition text-sm"
            required>
        </div>

        <!-- Descripción -->
        <div class="relative">
          <textarea
            name="descripcion_corta"
            x-model="descripcion_corta"
            rows="3"
            placeholder="Descripción breve del producto"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 resize-none focus:outline-none focus:border-indigo-500 transition text-sm"></textarea>
        </div>




        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-4">
          <button
            type="submit"

            @click="validarYEnviar"

            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-md transition text-sm">
            Guardar
          </button>
          <button
            type="button"
            @click="closeCreateModal"
            class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg shadow-md transition text-sm">
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>






  <!-- Modal Editar Producto -->
  <div
    x-show="showEdit"

    x-transition
    x-cloak
    class="fixed inset-0 bg-black/60 backdrop-blur-sm flex justify-center items-center z-50 px-4">
    <div class="bg-white p-8 rounded-2xl w-full max-w-3xl shadow-2xl">
      <h3 class="text-3xl font-bold mb-3 text-gray-800 relative">
        Editar Producto
        <span class="absolute left-0 bottom-[-16px] w-full border-b-2 border-gray-200"></span>
      </h3>

      <form :action="`/admin/productos/${productoEdit.id}`" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nombre -->
        <div class="relative mb-4">
          <input type="text" name="nombre" x-model="productoEdit.nombre"
            placeholder="Nombre del producto"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500"
            required>
        </div>

        <!-- Precio, descuento, stock -->
        <div class="grid grid-cols-3 gap-4 mb-6">
          <input type="number" step="0.01" name="precio" x-model="productoEdit.precio"
            placeholder="Precio"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">

          <input type="number" step="0.01" name="precio_descuento" x-model="productoEdit.precio_descuento"
            placeholder="Precio con Descuento"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">

          <input type="number" name="stock" x-model="productoEdit.stock"
            placeholder="Stock"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">
        </div>

        <!-- Categoría / Tipo / Marca -->
        <div class="grid grid-cols-3 gap-6 mb-6">
          <!-- Categoría -->
          <div>
            <label class="text-sm text-gray-600 mb-1 block">Categoría</label>
            <select name="categoria_id" x-model="productoEdit.categoria_id"
              class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500" required>
              <option value="" disabled selected>Seleccione categoría</option>
              @foreach($categorias as $categoria)
              <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tipo -->
          <div>
            <label class="text-sm text-gray-600 mb-1 block">Tipo</label>
            <select name="tipo_producto_id" x-model="productoEdit.tipo_producto_id"
              class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500" required>
              <option value="" disabled selected>Seleccione tipo</option>
              @foreach($tipoproducto as $tipo)
              <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
              @endforeach
            </select>
          </div>

          <!-- Marca -->
          <div>
            <label class="text-sm text-gray-600 mb-1 block">Marca</label>
            <select name="marca_id" x-model="productoEdit.marca_id"
              class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500" required>
              <option value="" disabled selected>Seleccione marca</option>
              @foreach($marcas as $marca)
              <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Tallas -->
        <div class="mt-6">
          <h4 class="text-sm font-semibold text-gray-700 mb-3">Selecciona tallas disponibles:</h4>
          <div class="flex justify-between items-start gap-6">
            <!-- Ropa -->
            <div class="flex flex-wrap gap-4 w-1/2 justify-start">
              <div class="w-full text-xs text-gray-500 mb-1 font-semibold">Tallas de ropa</div>
              @foreach($tallas as $talla)
              @if(!is_numeric($talla->nombre))
              <label class="flex items-center space-x-2">
                <input type="checkbox" name="tallas[]" value="{{ $talla->id }}"
                  x-bind:checked="productoEdit.tallas.includes({{ $talla->id }})"
                  class="form-checkbox text-indigo-600">
                <span class="text-sm text-gray-800">{{ $talla->nombre }}</span>
              </label>
              @endif
              @endforeach
            </div>

            <div class="w-px bg-gray-300 h-auto self-stretch"></div>

            <!-- Calzado -->
            <div class="flex flex-wrap gap-4 w-1/2 justify-start">
              <div class="w-full text-xs text-gray-500 mb-1 font-semibold">Tallas de calzado</div>
              @foreach($tallas as $talla)
              @if(is_numeric($talla->nombre))
              <label class="flex items-center space-x-2">
                <input type="checkbox" name="tallas[]" value="{{ $talla->id }}"
                  :checked="productoEdit.tallas.includes({{ $talla->id }})"
                  class="form-checkbox text-indigo-600">
                <span class="text-sm text-gray-800">{{ $talla->nombre }}</span>
              </label>
              @endif
              @endforeach
            </div>
          </div>
        </div>

        <!-- Descripción -->
        <div class="mt-6">
          <textarea name="descripcion_corta" x-model="productoEdit.descripcion_corta"
            placeholder="Descripción breve del producto"
            rows="3"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm resize-none focus:outline-none focus:border-indigo-500"></textarea>
        </div>

        <!-- Imagen -->
        <div class="mt-4">
          <input type="file" name="imagen_principal" accept="image/*"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">
          <p class="text-sm text-gray-500 mt-1">* Si no deseas cambiar la imagen, deja este campo vacío.</p>
        </div>

        <!-- Estado y destacado -->
        <div class="grid grid-cols-2 gap-4 mt-6">
          <select name="estado" x-model="productoEdit.estado"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>

          <select name="destacado" x-model="productoEdit.destacado"
            class="w-full border-0 border-b-2 border-gray-300 px-2 py-2 text-sm focus:outline-none focus:border-indigo-500">
            <option value="1">Destacado</option>
            <option value="0">No destacado</option>
          </select>
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-4 pt-6">
          <button type="submit"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2.5 rounded-lg shadow-md transition text-sm">
            Actualizar
          </button>
          <button type="button" @click="closeEditModal"
            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow-md transition text-sm">
            Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>


  <!-- Alpine.js Component -->
  <script>
    function productoManager() {
      return {
        showCreate: false,
        showEdit: false,

        aplicaDescuento: false,
        precio: 0,
        porcentaje: 0,
        nombre: '',
        stock: '',
        descripcion_corta: '',
        categoria: '',
        tipo_producto_id: '',
        marca_id: '',
        nuevoTipo: {
          nombre: '',
          descripcion: '',
          estado: ''
        },
        nuevaMarca: {
          nombre: '',
          descripcion: '',
          estado: ''
        },
        showAddTipo: false,
        showAddMarca: false,

        productoEdit: {
          id: '',
          nombre: '',
          precio: '',
          precio_descuento: '',
          stock: '',
          descripcion_corta: '',
          categoria_id: '',
          tipo_producto_id: '',
          marca_id: '',
          estado: '',
          destacado: '',
          tallas: []
        },

        init() {
          this.showCreate = false;
          this.showEdit = false;
        },

        openCreateModal() {
          this.resetCreateForm();
          this.showCreate = true;
        },

        closeCreateModal() {
          this.showCreate = false;
        },

        resetCreateForm() {
          this.aplicaDescuento = false;
          this.precio = 0;
          this.porcentaje = 0;
          this.nombre = '';
          this.stock = '';
          this.descripcion_corta = '';
          this.categoria = '';
          this.tipo_producto_id = '';
          this.marca_id = '';
          this.nuevoTipo = {
            nombre: '',
            descripcion: '',
            estado: ''
          };
          this.nuevaMarca = {
            nombre: '',
            descripcion: '',
            estado: ''
          };
        },

        openEditModal(producto) {
          this.closeCreateModal();
          this.productoEdit = {
            ...producto,
            tallas: producto.tallas ?? []
          };
          this.showEdit = true;
        },

        closeEditModal() {
          this.showEdit = false;
        },

        tieneValor(campo) {
          return campo && campo.toString().trim() !== '';
        },

        validarYEnviar() {
          if (!this.tipo_producto_id || !this.marca_id) {
            alert('Debes seleccionar una marca y un tipo de producto válidos');
            return;
          }
          if (!this.nombre || !this.precio || !this.stock || !this.categoria) {
            alert('Completa todos los campos obligatorios.');
            return;
          }
          if (this.aplicaDescuento && (this.porcentaje < 0 || this.porcentaje > 100)) {
            alert('El porcentaje de descuento debe estar entre 0 y 100.');
            return;
          }
          this.$refs.createForm.submit();
        }
      }
    }
  </script>


  @endsection