<?php

namespace App\Http\Controllers;

use App\Models\Suscriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SuscripcionController extends Controller
{
    public function guardar(Request $request)
    {
        try {
            $data = $request->only(['nombre', 'correo', 'telefono', 'interes']);

            // Validación
            $validator = Validator::make($data, [
                'nombre' => 'required|string|max:255',
                'correo' => 'nullable|email|max:255',
                'telefono' => 'nullable|string|max:20',
                'interes' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Datos inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Validación lógica adicional
            if (empty($data['correo']) && empty($data['telefono'])) {
                return response()->json([
                    'message' => 'Debe ingresar al menos un medio de contacto (correo o teléfono).'
                ], 400);
            }

            // Guardar en la base de datos
            $suscriptor = Suscriptor::create($data);

            return response()->json([
                'message' => 'Suscripción exitosa',
                'suscriptor' => $suscriptor
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al guardar suscripción: ' . $e->getMessage());

            return response()->json([
                'message' => 'Ocurrió un error al guardar',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
