@extends('layouts.adminpanel')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6 sm:px-8 lg:px-10 overflow-auto max-h-[90vh] bg-transparent rounded-lg">

    <!-- Encabezado -->
    <h1 class="text-white text-3xl font-bold mb-8 border-b-1 border-gray-200 pb-3 w-full">
        Administradores
    </h1>

    <!-- Formulario de creación (placeholders en inputs) -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-10 w-full">
        <form action="" method="POST" class="space-y-6 w-full">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <input type="text" name="nombre" placeholder="Nombre" required
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="text" name="apellido" placeholder="Apellido" required
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="tel" name="telefono" placeholder="Teléfono" required pattern="[0-9]{7,15}"
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="email" name="email" placeholder="Correo electrónico" required
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="password" name="password" placeholder="Contraseña" required
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />

                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required
                    class="w-full px-4 py-3 text-base rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full md:w-auto inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white text-base hover:bg-indigo-700 transition">
                    Guardar administrador
                </button>
            </div>
        </form>
    </div>

    <div class="flex justify-end space-x-4 pb-4 ">
        <a href="{{ route('admin.usuariosweb.export.pdf') }}"
        class="inline-flex items-center gap-2 px-5 py-2 bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-800 font-semibold text-sm rounded-sm transition-all duration-200">
            📄 Exportar PDF
        </a>
        <a href=""
        class="inline-flex items-center gap-2 px-5 py-2 bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-800 font-semibold text-sm rounded-sm shadow-md transition-all duration-200">
            📊 Exportar Excel
        </a>
    </div>

    <!-- Tabla de administradores -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-indigo-200">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Email</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-indigo-800">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-indigo-100">
                @foreach ($admins as $admin)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $admin->email }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href=""
                                class="inline-flex items-center px-4 py-1 bg-indigo-100 text-indigo-700 font-medium text-sm rounded hover:bg-indigo-200 transition">
                                ✏️ Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $admins->links() }}
    </div>
</div>
@endsection
