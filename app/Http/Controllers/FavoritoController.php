<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use Illuminate\Support\Facades\Storage; // <== ESTA LÍNEA ES IMPORTANTE


class FavoritoController extends Controller
{
    public function index()
    {
        $productos = Favorito::where('user_id', auth()->id())
            ->with('producto')
            ->get()
            ->pluck('producto')
            ->map(function ($p) {
                if (!$p) return null; 
                logger()->info('Imagen principal: ' . $p->imagen_principal);
                $p->imagen = asset($p->imagen_principal);
                return $p;
            })
            ->filter(); 

        return response()->json($productos);
    }


    public function toggle(Request $request)
    {
        $user = auth()->user();
        $productoId = $request->input('producto_id');

        $favorito = Favorito::where('user_id', $user->id)
            ->where('producto_id', $productoId)
            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json(['status' => 'eliminado']);
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'producto_id' => $productoId,
            ]);
            return response()->json(['status' => 'agregado']);
        }
    }
}
