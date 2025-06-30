@extends('layouts.adminpanel')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6 sm:px-8 lg:px-10 overflow-auto max-h-[90vh] bg-transparent rounded-lg">

   <h1 class="text-white text-3xl font-bold mb-7 border-b border-gray-200 pb-3 w-full">
    Usuarios Web
    </h1>
     
    <div class="flex justify-end space-x-4 pb-4 ">
        <!-- Botón Exportar PDF -->
        <a href="{{ route('admin.usuariosweb.export.pdf') }}"
        class="inline-flex items-center gap-2 px-5 py-2 bg-red-100 text-red-700 hover:bg-red-200 hover:text-red-800 font-semibold text-sm rounded-sm transition-all duration-200">
            📄 Exportar PDF
        </a>

        <!-- Botón Exportar Excel -->
        <a href="{{ route('admin.usuariosweb.export.excel') }}"
        class="inline-flex items-center gap-2 px-5 py-2 bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-800 font-semibold text-sm rounded-sm shadow-md transition-all duration-200">
            📊 Exportar Excel
        </a>
    </div>



    <!-- Tabla de usuarios -->
    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
        <table class="min-w-full divide-y divide-indigo-200">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Email</th>
                     <!--<th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Email verificado</th>-->
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Creado</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-indigo-800">Actualizado</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-indigo-800">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-indigo-100">
                @foreach ($users as $user)
                    <tr class="hover:bg-indigo-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                        <!-- <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i') : 'No verificado' }}
                        </td>-->
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->updated_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href="#"
                                class="inline-flex items-center px-4 py-1 bg-indigo-100 text-indigo-700 font-medium text-sm rounded-lg hover:bg-indigo-200 transition">
                                ✏️ Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
