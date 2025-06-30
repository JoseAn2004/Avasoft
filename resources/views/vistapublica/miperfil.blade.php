@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="flex min-h-screen bg-gray-100">
  <!-- Sidebar -->
  <aside class="w-72 bg-white shadow-md border-r border-gray-200 flex flex-col">
    <div class="bg-orange-500 text-white py-6 px-4 rounded-b-xl">
      <div class="text-center">
        <div class="mb-2">
          <img class="w-16 h-16 mx-auto rounded-full border-4 border-white shadow-md"
            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
            alt="Avatar">
        </div>
        <h1 class="text-lg font-semibold">¡Bienvenido {{ Auth::user()->name }}!</h1>
        <p class="text-sm text-orange-100">{{ Auth::user()->email }}</p>
      </div>
    </div>

    <nav class="mt-6 space-y-1 flex-1 px-3">
      <button class="tab-btn w-full flex items-center gap-3 px-4 py-2 rounded-md hover:bg-orange-100 transition" data-tab="perfil">
        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4.992 4.992 0 015 16V7a2 2 0 012-2h10a2 2 0 012 2v9a4.992 4.992 0 01-.121 1.804M15 21H9m6 0v-1a3 3 0 00-6 0v1" />
        </svg>
        Perfil
      </button>
      <button class="tab-btn w-full flex items-center gap-3 px-4 py-2 rounded-md hover:bg-orange-100 transition" data-tab="direcciones">
        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657A8 8 0 1112 4v8l5.657 4.657z" />
        </svg>
        Direcciones
      </button>
      <button class="tab-btn w-full flex items-center gap-3 px-4 py-2 rounded-md hover:bg-orange-100 transition" data-tab="pedidos">
        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3V3zm0 6h18v12H3V9zm4 4h2v4H7v-4z" />
        </svg>
        Pedidos
      </button>
      <button class="tab-btn w-full flex items-center gap-3 px-4 py-2 rounded-md hover:bg-orange-100 transition" data-tab="favoritos">
        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5v16l7-5 7 5V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
        </svg>
        Favoritos
      </button>
    </nav>

    <div class="px-3 py-4 border-t mt-auto">
      <form method="POST" action="{{ route('logout.cliente') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition rounded-md">
          <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
          </svg>
          Cerrar sesión
        </button>
      </form>
    </div>
  </aside>

  <!-- Contenido -->
  <main class="flex-1 p-8">
    <div class="max-w-4xl mx-auto space-y-8">
      <section id="perfil" class="tab-content max-w-xl mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 border-b border-gray-300 pb-2 mb-6">Mi Perfil</h2>

        <form id="profileForm" action="{{ route('perfil.actualizar') }}" method="POST" novalidate>
          @csrf
          @method('PUT')

          <!-- Nombre -->
          <div class="relative mb-6">
            <label for="name" class="block text-gray-700 font-semibold mb-1">Nombre:</label>
            <p class="view-mode text-lg text-gray-800 font-semibold">{{ $usuario->name }}</p>
            <input
              id="name"
              type="text"
              name="name"
              value="{{ $usuario->name }}"
              class="edit-mode hidden w-full border-b border-gray-400 focus:outline-none focus:border-orange-500 bg-transparent text-gray-800 py-2 px-1 transition"
              autocomplete="name"
              required />
          </div>

          <!-- Email -->
          <div class="relative mb-6">
            <label for="email" class="block text-gray-700 font-semibold mb-1">Email:</label>
            <p class="view-mode text-lg text-gray-800 font-semibold">{{ $usuario->email }}</p>
            <input
              id="email"
              type="email"
              name="email"
              value="{{ $usuario->email }}"
              class="edit-mode hidden w-full border-b border-gray-400 focus:outline-none focus:border-orange-500 bg-transparent text-gray-800 py-2 px-1 transition"
              autocomplete="email"
              required />
          </div>

          <!-- DNI -->
          <div class="relative mb-6">
            <label for="dni" class="block text-gray-700 font-semibold mb-1">DNI:</label>
            <p class="view-mode text-lg text-gray-800 font-semibold">{{ $usuario->perfil->dni ?? '-' }}</p>
            <input
              id="dni"
              type="text"
              name="dni"
              value="{{ $usuario->perfil->dni ?? '' }}"
              class="edit-mode hidden w-full border-b border-gray-400 focus:outline-none focus:border-orange-500 bg-transparent text-gray-800 py-2 px-1 transition"
              required />
          </div>

          <!-- Teléfono -->
          <div class="relative mb-6">
            <label for="telefono" class="block text-gray-700 font-semibold mb-1">Teléfono:</label>
            <p class="view-mode text-lg text-gray-800 font-semibold">{{ $usuario->perfil->telefono ?? '-' }}</p>
            <input
              id="telefono"
              type="text"
              name="telefono"
              value="{{ $usuario->perfil->telefono ?? '' }}"
              class="edit-mode hidden w-full border-b border-gray-400 focus:outline-none focus:border-orange-500 bg-transparent text-gray-800 py-2 px-1 transition"
              required />
          </div>

          <!-- Botón -->
          <button
            type="button"
            id="editSaveBtn"
            class="bg-orange-500 text-white px-5 py-2 rounded hover:bg-orange-600 transition">
            Editar
          </button>
        </form>
      </section>

      <!-- Script para alternar entre vista y edición -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const btn = document.getElementById('editSaveBtn');

          if (!btn) return;

          btn.addEventListener('click', function() {
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input[name="name"], input[name="email"], input[name="dni"], input[name="telefono"]');
            const views = form.querySelectorAll('.view-mode');

            if (btn.innerText === 'Editar') {
              inputs.forEach(input => input.classList.remove('hidden'));
              views.forEach(text => text.classList.add('hidden'));
              btn.innerText = 'Guardar';
              inputs[0].focus();
            } else {
              const name = form.name.value.trim();
              const email = form.email.value.trim();
              const dni = form.dni.value.trim();
              const telefono = form.telefono.value.trim();

              if (name === '') {
                alert('El campo Nombre es obligatorio.');
                form.name.focus();
                return;
              }

              if (email === '') {
                alert('El campo Email es obligatorio.');
                form.email.focus();
                return;
              }

              const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              if (!emailRegex.test(email)) {
                alert('Por favor, ingresa un correo electrónico válido.');
                form.email.focus();
                return;
              }

              if (dni === '') {
                alert('El campo DNI es obligatorio.');
                form.dni.focus();
                return;
              }

              if (telefono === '') {
                alert('El campo Teléfono es obligatorio.');
                form.telefono.focus();
                return;
              }

              // Enviar formulario
              form.submit();
            }
          });
        });
      </script>

      <!-- Direcciones -->
      <section id="direcciones" class="tab-content hidden">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2 mb-4">Direcciones</h2>

        <div class="bg-white p-6 rounded-lg shadow-sm">
          <!-- Dirección actual -->
          <div id="direccionVista" class="{{ $usuario->perfil->direccion ? '' : 'hidden' }}">
            <p class="text-lg text-gray-700 mb-4">
              <span class="font-semibold text-gray-800">Dirección actual:</span>
              <span class="text-gray-700 ml-2">
                {{ $usuario->perfil->direccion ?? 'No registrada' }}
              </span>
            </p>
          </div>




          <!-- Formulario oculto -->
          <form id="direccionForm" action="{{ route('perfil.actualizarDireccion') }}" method="POST" class="hidden mt-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <label for="lugar" class="block text-gray-700 font-semibold mb-1">Lugar:</label>
                <input
                  type="text"
                  id="lugar"
                  value="{{ old('lugar', explode(',', $usuario->perfil->direccion)[0] ?? '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>

              <div>
                <label for="numero" class="block text-gray-700 font-semibold mb-1">Número:</label>
                <input
                  type="text"
                  id="numero"
                  value="{{ old('numero', preg_match('/Nº\s?(\d+)/', $usuario->perfil->direccion, $n) ? $n[1] : '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>

              <div>
                <label for="distrito" class="block text-gray-700 font-semibold mb-1">Distrito:</label>
                <input
                  type="text"
                  id="distrito"
                  value="{{ old('distrito', explode(',', $usuario->perfil->direccion)[2] ?? '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>

              <div>
                <label for="provincia" class="block text-gray-700 font-semibold mb-1">Provincia:</label>
                <input
                  type="text"
                  id="provincia"
                  value="{{ old('provincia', explode(',', $usuario->perfil->direccion)[3] ?? '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>

              <div>
                <label for="departamento" class="block text-gray-700 font-semibold mb-1">Departamento:</label>
                <input
                  type="text"
                  id="departamento"
                  value="{{ old('departamento', explode(',', $usuario->perfil->direccion)[4] ?? '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>

              <div class="md:col-span-2">
                <label for="referencia" class="block text-gray-700 font-semibold mb-1">Referencia:</label>
                <input
                  type="text"
                  id="referencia"
                  value="{{ old('referencia', str_contains($usuario->perfil->direccion, 'Ref:') ? explode('Ref:', $usuario->perfil->direccion)[1] : '') }}"
                  class="w-full border-b border-gray-400 bg-transparent py-2 px-1 focus:outline-none focus:border-orange-500"
                  required>
              </div>
            </div>

            <input type="hidden" name="direccion" id="direccion" value="">

            <div class="flex justify-end">
              <button type="submit" class="bg-orange-500 text-white px-5 py-2 rounded hover:bg-orange-600 transition">
                Guardar
              </button>
            </div>
          </form>

          <!-- Botón + para mostrar el formulario -->
          <div class="text-center mt-6">
            <button
              id="mostrarFormularioBtn"
              class="text-3xl text-orange-500 font-bold hover:text-orange-600 transition focus:outline-none"
              title="Agregar dirección">
              +
            </button>
          </div>
        </div>
      </section>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const mostrarFormularioBtn = document.getElementById('mostrarFormularioBtn');
          const direccionForm = document.getElementById('direccionForm');
          const direccionVista = document.getElementById('direccionVista');

          mostrarFormularioBtn.addEventListener('click', function() {
            direccionForm.classList.remove('hidden');
            mostrarFormularioBtn.classList.add('hidden');
            direccionVista.classList.add('hidden');
            document.getElementById('lugar').focus();
          });

          direccionForm.addEventListener('submit', function(e) {
            const lugar = document.getElementById('lugar').value.trim();
            const numero = document.getElementById('numero').value.trim();
            const distrito = document.getElementById('distrito').value.trim();
            const provincia = document.getElementById('provincia').value.trim();
            const departamento = document.getElementById('departamento').value.trim();
            const referencia = document.getElementById('referencia').value.trim();

            const direccionCompleta = `${lugar}, Nº ${numero}, ${distrito}, ${provincia}, ${departamento}, Ref: ${referencia}`;
            document.getElementById('direccion').value = direccionCompleta;
          });
        });
      </script>





      <section id="pedidos" class="tab-content hidden">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Mis pedidos</h2>
        <div id="listaPedidos" class="bg-white p-6 rounded-lg shadow-sm mt-4">
          <p>Cargando pedidos...</p>
        </div>

        <div id="listaPedidos"></div>

        <!-- Modal para detalle -->
        <div id="modalDetalle" class="fixed inset-0 bg-black/20 hidden justify-center items-center z-50">
          <div class="bg-white p-6 rounded-lg border border-gray-200 w-full max-w-md relative">
            <button onclick="cerrarDetalle()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl transition">
              ✕
            </button>
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Detalle del pedido</h2>
            <div id="contenidoDetalle" class="text-sm text-gray-700 space-y-2"></div>
          </div>
        </div>



      </section>
      <script>
        document.addEventListener('DOMContentLoaded', () => {
          fetch('/mis-pedidos-json')
            .then(res => res.json())
            .then(pedidos => {
              const contenedor = document.getElementById('listaPedidos');
              contenedor.innerHTML = '';

              if (!pedidos.length) {
                contenedor.innerHTML = '<p class="text-gray-600 italic">No tienes pedidos aún.</p>';
                return;
              }

              pedidos.forEach(p => {
                const fecha = new Date(p.created_at);
                const fechaStr = fecha.toLocaleDateString('es-PE', {
                  day: '2-digit',
                  month: 'long',
                  year: 'numeric'
                });
                const horaStr = fecha.toLocaleTimeString('es-PE', {
                  hour: '2-digit',
                  minute: '2-digit'
                });

                contenedor.innerHTML += `
    <div class="bg-white border border-gray-200 rounded-lg p-5 mb-5 transition duration-150">
      <div class="flex justify-between items-center mb-3">
        <h3 class="text-lg font-semibold text-gray-800">Pedido #${p.id}</h3>
        <span class="text-sm font-medium px-3 py-1 rounded-full ${
  p.estado === 'pendiente'
  ? 'bg-yellow-100 text-yellow-800'        // Amarillo: algo está pendiente, en espera.
: p.estado === 'verificado'
  ? 'bg-blue-100 text-blue-800'            // Azul: indica que fue revisado/verificado.
: p.estado === 'preparando'
  ? 'bg-indigo-100 text-indigo-800'        // Indigo: proceso activo, preparando.
: p.estado === 'en camino'
  ? 'bg-sky-100 text-sky-800'              // Azul cielo: en tránsito, movimiento.
: p.estado === 'listo para recojo'
  ? 'bg-orange-100 text-orange-800'        // Naranja: listo para ser recogido.
: p.estado === 'completado'
  ? 'bg-green-100 text-green-800'          // Verde: finalizado con éxito.
: p.estado === 'rechazado'
  ? 'bg-rose-100 text-rose-800'            // Rosa fuerte: rechazado, error o negativa.
: p.estado === 'cancelado'
  ? 'bg-gray-200 text-gray-700'            // Gris claro: cancelado, estado neutro.
: 'bg-gray-100 text-gray-600'              // Por defecto: estado desconocido.

}">${p.estado}</span>

      </div>
      <p class="text-sm text-gray-600 mb-1">Realizado el <span class="italic">${fechaStr}</span> a las <span>${horaStr}</span></p>
      <p class="text-sm text-gray-700 mb-3">Total: <strong class="text-gray-900">S/ ${parseFloat(p.total).toFixed(2)}</strong></p>

      <div class="text-right">
       <button onclick='verDetalle(${JSON.stringify(p)})'
  class="p-2 rounded hover:bg-orange-100 transition" title="Ver detalle del pedido">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 480.83"
    class="w-5 h-5 text-orange-600 fill-current">
    <path d="M380.38 368.78c9.9 0 18.9 4.04 25.39 10.53a35.841 35.841 0 0 1 10.51 25.39c0 9.88-4.03 18.87-10.51 25.36a35.769 35.769 0 0 1-25.39 10.53c-9.89 0-18.86-4.02-25.37-10.53-6.51-6.49-10.54-15.48-10.54-25.36 0-9.9 4.02-18.88 10.53-25.38 6.53-6.53 15.49-10.54 25.38-10.54zm-149.46 84.43H31.51c-8.59 0-16.53-3.57-22.25-9.29C3.58 438.24 0 430.38 0 421.7V31.51C0 22.89 3.54 15.02 9.24 9.3l.06-.06C15.05 3.53 22.9 0 31.51 0h383.58c8.62 0 16.48 3.6 22.18 9.3 5.75 5.7 9.32 13.64 9.32 22.21v279.43c-9.73-3.41-19.66-6.14-29.71-8.14V31.51c0-.42-.23-.87-.6-1.23-.3-.36-.73-.56-1.19-.56H31.51c-.51 0-.96.19-1.25.48l-.06.06c-.29.29-.48.74-.48 1.25V421.7c0 .43.22.87.56 1.21.35.35.8.58 1.23.58h172.24c1.31 2.38 2.89 4.67 4.74 6.84 6.96 8.14 14.46 15.78 22.43 22.88zm-86.19-339.84h215.33c1.25 0 2.29 1.11 2.29 2.31v28.55c0 1.2-1.11 2.3-2.29 2.3H144.73c-1.17 0-2.29-1.03-2.29-2.3v-28.55c0-1.27 1.04-2.31 2.29-2.31zm0 193.81h175.5c-6.18 1.83-12.36 3.98-18.53 6.45-12.14 4.87-30.93 14.61-49.13 26.71H144.73c-1.19 0-2.29-1.04-2.29-2.3v-28.57a2.31 2.31 0 0 1 2.29-2.29zm-41.44-2.46c10.51 0 19.04 8.53 19.04 19.04 0 10.52-8.53 19.04-19.04 19.04s-19.04-8.52-19.04-19.04c0-10.51 8.53-19.04 19.04-19.04zm41.44-94.62h215.33c1.25 0 2.29 1.08 2.29 2.3v28.55c0 1.22-1.08 2.31-2.29 2.31H144.73c-1.2 0-2.29-1.04-2.29-2.31V212.4c0-1.27 1.04-2.3 2.29-2.3zm-41.44-2.46c10.51 0 19.04 8.52 19.04 19.03 0 10.52-8.53 19.05-19.04 19.05s-19.04-8.53-19.04-19.05c0-10.51 8.53-19.03 19.04-19.03zm0-96.73c10.51 0 19.04 8.53 19.04 19.04s-8.53 19.04-19.04 19.04-19.04-8.53-19.04-19.04 8.53-19.04 19.04-19.04zm147.84 287.63c31.66-38.28 72.71-68.93 123.86-69.99 54.28-1.13 99.43 31.28 134.78 70.13a8.601 8.601 0 0 1 .48 10.97c-29.89 42.16-77.07 70.86-129.62 71.17-54.09.31-96.84-29.45-130.01-71.02-2.7-3.4-2.4-8.22.51-11.26zm20.4 5.97c29.66 34.5 62.8 56.44 109.03 56.18 44.37-.26 82.11-20.95 108.74-55.59-31.3-32.69-67.27-57.4-113.97-56.44-43.66.92-75.76 23.96-103.8 55.85zm98.73-28.79c7.7 0 13.92 6.24 13.92 13.93 0 7.69-6.22 13.93-13.92 13.93-7.68 0-13.92-6.24-13.92-13.93 0-7.69 6.24-13.93 13.92-13.93z"/>
  </svg>
</button>



      </div>
    </div>
  `;
              });


            })
            .catch(err => {
              console.error('Error al cargar pedidos:', err);
              document.getElementById('listaPedidos').innerHTML = '<p class="text-red-500">Error al cargar pedidos.</p>';
            });
        });

        function verDetalle(pedido) {
          const modal = document.getElementById('modalDetalle');
          const contenido = document.getElementById('contenidoDetalle');
          const fecha = new Date(pedido.created_at).toLocaleString('es-PE');

          let html = `
      <p><strong>Pedido #${pedido.id}</strong></p>
      <p>Fecha: ${fecha}</p>
      <p>Estado: <span class="capitalize">${pedido.estado}</span></p>
      <p>Total: <strong>S/ ${parseFloat(pedido.total).toFixed(2)}</strong></p>
      <hr class="my-2">
      <p class="font-semibold">Productos:</p>
      <ul class="space-y-1">
    `;

          pedido.items.forEach(i => {
            const nombre = i.product?.nombre || `Producto ID ${i.product_id}`;
            html += `<li class="flex justify-between">
                <span>${i.cantidad} x ${nombre}</span>
                <span>S/ ${parseFloat(i.precio_unitario).toFixed(2)}</span>
              </li>`;
          });

          html += '</ul>';
          contenido.innerHTML = html;
          modal.classList.remove('hidden');
          modal.classList.add('flex');
        }

        function cerrarDetalle() {
          document.getElementById('modalDetalle').classList.remove('flex');
          document.getElementById('modalDetalle').classList.add('hidden');
        }
      </script>








      <!-- Favoritos -->
      <section id="favoritos" class="tab-content hidden">
        <h2 class="text-2xl font-bold text-gray-800 border-b pb-2">Favoritos</h2>
        <div id="favoritos-lista" class="bg-white p-6 rounded-lg shadow-sm mt-4">
          <p>Cargando favoritos...</p>
        </div>


      </section>


    </div>
  </main>
</div>

<!-- Script de pestañas -->
<script>
  document.querySelectorAll('.tab-btn').forEach((button) => {
    button.addEventListener('click', () => {
      const selectedTab = button.getAttribute('data-tab');

      // Ocultar todas las secciones
      document.querySelectorAll('.tab-content').forEach((section) => {
        section.classList.add('hidden');
      });

      // Mostrar la sección correspondiente
      document.getElementById(selectedTab).classList.remove('hidden');

      // Estilo de pestaña activa
      document.querySelectorAll('.tab-btn').forEach((btn) => {
        btn.classList.remove('bg-orange-100', 'text-orange-700');
      });

      button.classList.add('bg-orange-100', 'text-orange-700');
    });
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');

    if (tab) {
      // Ocultar todas las pestañas
      document.querySelectorAll('.tab-content').forEach(section => {
        section.classList.add('hidden');
      });

      // Mostrar la pestaña solicitada
      const targetTab = document.getElementById(tab);
      if (targetTab) {
        targetTab.classList.remove('hidden');
      }

      // Opcional: actualizar estado visual de botones tab-btn si tienes
      document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.getAttribute('data-tab') === tab);
      });
    }
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const lista = document.getElementById('favoritos-lista');

    function cargarFavoritos() {
      fetch('/favoritos', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include' // Importante si usas cookies (Laravel Sanctum)
        })
        .then(response => response.json())
        .then(favoritos => {
          if (!favoritos || favoritos.length === 0) {
            lista.innerHTML = '<p>No tienes productos favoritos aún.</p>';
            return;
          }

          lista.innerHTML = ''; // Limpiar lista antes de pintar
          favoritos.forEach(prod => {
            const item = document.createElement('div');
            item.className = 'flex items-center gap-4 mb-4 border-b border-gray-200 pb-4'; // agregué borde gris claro

            item.innerHTML = `
              <img src="${prod.imagen}" alt="${prod.nombre}" class="w-64 h-64 object-contain rounded-xl transition-transform duration-500 ease-in-out transform hover:scale-110 cursor-zoom-in shadow-md">

              <div class="flex flex-col justify-center">
                <h4 class="text-sm font-semibold text-gray-800">${prod.nombre}</h4>
                <button class="flex items-center gap-1 text-gray-400 hover:text-red-500 text-xs mt-1 transition-colors duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                  Eliminar
                </button>
              </div>
            `;

            const boton = item.querySelector('button');
            boton.addEventListener('click', () => {
              Swal.fire({
                title: `¿Eliminar ${prod.nombre} de favoritos?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // rojo para confirmar
                cancelButtonColor: '#3085d6', // azul para cancelar
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.isConfirmed) {
                  eliminarFavorito(prod.id, item);
                }
              });
            });

            lista.appendChild(item);
          });

        })
        .catch(err => {
          console.error('Error al cargar favoritos:', err);
          lista.innerHTML = '<p>Error al cargar los favoritos.</p>';
        });
    }

    function eliminarFavorito(productoId, elementoDOM) {
      fetch('/favorito/toggle', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
          },
          credentials: 'include',
          body: JSON.stringify({
            producto_id: productoId
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'eliminado') {
            // Animación suave antes de remover
            elementoDOM.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            elementoDOM.style.opacity = '0';
            elementoDOM.style.transform = 'scale(0.9)';
            setTimeout(() => {
              elementoDOM.remove();
              if (lista.children.length === 0) {
                lista.innerHTML = '<p>No tienes productos favoritos aún.</p>';
              }
            }, 300);
          }
        })
        .catch(err => {
          console.error('Error al eliminar favorito:', err);
          alert('Ocurrió un error al intentar eliminar el favorito.');
        });
    }


    cargarFavoritos();
  });
</script>

@endsection