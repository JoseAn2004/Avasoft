<?php

namespace App\Http\Controllers\Admin;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\TipoProducto;
use App\Models\Marca;
use App\Models\Talla;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class ProductosController extends Controller
{
    public function index()
    {
        try {

            $productos = Producto::with(['tallas', 'categoria', 'marca', 'tipoProducto'])->paginate(10);
            $categorias = Categoria::all();
            $tipoproducto = TipoProducto::all();
            $marcas = Marca::all();
            $tallas = Talla::all();

            return view('admin.productos.index', compact('productos', 'categorias', 'tipoproducto', 'marcas', 'tallas'));
        } catch (\Exception $e) {
            // Manejo de errores
            Log::error('Error en ProductosController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al cargar los productos.');
        }
    }






    public function create()
    {
        $categorias = Categoria::all();
        $tipoproducto = TipoProducto::all();
        $marcas = Marca::all();
        $tallas = Talla::where('estado', 'activo')->get(); // Asegúrate de esto

        return view('admin.productos.create', compact('categorias', 'tipoproducto', 'marcas', 'tallas'));
    }



    public function store(Request $request)
    {
        // Mostrar todos los datos del formulario (esto es solo para depuración)
        // dd($request->all());
        //dd($request->only(['tipo_producto_id', 'marca_id']));

        $request->validate([
            'nombre' => 'required',
            'descripcion_corta' => 'nullable|string',
            'precio' => 'required|numeric',
            'precio_descuento' => 'nullable|numeric',
            'stock' => 'required|integer',
            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_producto_id' => 'nullable|exists:tipo_productos,id', // ✅
            'marca_id' => 'nullable|exists:marcas,id',
            'estado' => 'nullable|in:activo,inactivo',
            'destacado' => 'nullable|boolean',
        ]);


        // Crear un slug para el producto
        $slug = Str::slug($request->nombre);

        // Inicializar la variable para la imagen
        $imagen_principal = null;

        // Si hay una imagen cargada
        if ($request->hasFile('imagen_principal')) {
            $imagen_principal = $request->file('imagen_principal');

            // Crear un nombre único para la imagen
            $imagen_principal_nombre = time() . '_' . $imagen_principal->getClientOriginalName();

            // Guardar la imagen en la carpeta 'productos' dentro de 'storage/app/public'
            $path = $imagen_principal->storeAs('productos', $imagen_principal_nombre, 'public');

            // Verificar la ruta donde se guardó la imagen
            // dd($path); // Esto te dará la ruta de almacenamiento, puedes usar Log::debug($path);
        }

        // Crear el producto en la base de datos
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'slug' => $slug,
            'descripcion_corta' => $request->descripcion_corta,
            'precio' => $request->precio,
            'precio_descuento' => $request->precio_descuento,
            'stock' => $request->stock,
            'imagen_principal' => $imagen_principal ? 'storage/productos/' . $imagen_principal_nombre : null,
            'categoria_id' => $request->categoria_id,
            'tipo_producto_id' => $request->tipo_producto_id ?: null,
            'marca_id' => $request->marca_id ?: null,
            'estado' => $request->estado ?? 'activo',
            'destacado' => $request->destacado ?? false,
        ]);

        if ($request->has('tallas')) {
            $producto->tallas()->attach($request->tallas);
        }



        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.productos.index')->with('success', 'Producto creado exitosamente');


        // dd($request->all());

    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        // Validación
        $request->validate([
            'nombre' => 'required',
            'descripcion_corta' => 'nullable|string',
            'precio' => 'required|numeric',
            'precio_descuento' => 'nullable|numeric',
            'stock' => 'required|integer',
            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_producto_id' => 'nullable|exists:tipo_productos,id',
            'marca_id' => 'nullable|exists:marcas,id',
            'estado' => 'nullable|in:activo,inactivo',
            'destacado' => 'nullable|boolean',
            'tallas' => 'nullable|array',
            'tallas.*' => 'exists:tallas,id',
        ]);

        $slug = Str::slug($request->nombre);

        // Inicializar con la imagen existente
        $imagen_principal_ruta = $producto->imagen_principal;

        // Si el usuario sube una nueva imagen
        if ($request->hasFile('imagen_principal')) {
            // Eliminar imagen anterior si existe
            if ($producto->imagen_principal && \Storage::disk('public')->exists(str_replace('storage/', '', $producto->imagen_principal))) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $producto->imagen_principal));
            }

            $imagen = $request->file('imagen_principal');
            $nombre_imagen = time() . '_' . $imagen->getClientOriginalName();
            $path = $imagen->storeAs('productos', $nombre_imagen, 'public');
            $imagen_principal_ruta = 'storage/' . $path;
        }

        // Actualizar el producto
        $producto->update([
            'nombre' => $request->nombre,
            'slug' => $slug,
            'descripcion_corta' => $request->descripcion_corta,
            'precio' => $request->precio,
            'precio_descuento' => $request->precio_descuento,
            'stock' => $request->stock,
            'imagen_principal' => $imagen_principal_ruta,
            'categoria_id' => $request->categoria_id,
            'tipo_producto_id' => $request->tipo_producto_id ?: null,
            'marca_id' => $request->marca_id ?: null,
            'estado' => $request->estado ?? 'activo',
            'destacado' => $request->destacado ?? false,
        ]);

        // Actualizar las tallas (sincronizar)
        if ($request->has('tallas')) {
            $producto->tallas()->sync($request->tallas);
        } else {
            // Si no se enviaron tallas, las quitamos
            $producto->tallas()->detach();
        }

        return redirect()->route('admin.productos.index')->with('success', 'Producto actualizado exitosamente');
    }


    public function destroy(Producto $producto)
    {
        if ($producto->imagen_principal) {
            \Storage::delete($producto->imagen_principal);
        }
        if ($producto->imagenes_adicionales) {
            $imagenes_adicionales = json_decode($producto->imagenes_adicionales);
            foreach ($imagenes_adicionales as $imagen) {
                \Storage::delete($imagen);
            }
        }

        $producto->delete();

        return redirect()->route('admin.productos.index')->with('success', 'Producto eliminado exitosamente');
    }


    public function mostrarPublico()
    {
        $productosHombre = Producto::where('categoria_id', 1)->get();
        $productosMujer = Producto::where('categoria_id', 2)->get();
        $productosAccesorios = Producto::where('categoria_id', 3)->get();

        // Para productos nuevos (últimos 5 días)
        $fechaLimite = \Carbon\Carbon::now()->subDays(5);
        $productosNuevos = Producto::where('created_at', '>=', $fechaLimite)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('productosHombre', 'productosMujer', 'productosAccesorios', 'productosNuevos'));
    }

    public function mostrarMujer()
    {
        $productos = Producto::where('categoria_id', 2)->paginate(10);
        return view('vistapublica.mujer', compact('productos'));
    }

    public function mostrarHombre()
    {
        // Suponiendo que 'Hombre' tiene categoria_id = 2
        $productos = Producto::where('categoria_id', 1)->paginate(10);
        return view('vistapublica.hombre', compact('productos'));
    }

    public function mostrarAccesorios()
    {
        // Suponiendo que 'Accesorios' tiene categoria_id = 3
        $productos = Producto::where('categoria_id', 3)->paginate(10);
        return view('vistapublica.accesorios', compact('productos'));
    }

    public function mostrarNuevosProductos()
    {
        $fechaLimite = Carbon::now()->subDays(5);

        $productos = Producto::where('created_at', '>=', $fechaLimite)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vistapublica.new', compact('productos'));
    }

    public function buscar(Request $request)
    {
        $term = $request->get('term');

        // Busca productos cuyo nombre contenga el término (ajusta el nombre del campo y tabla)
        $productos = Producto::where('nombre', 'LIKE', '%' . $term . '%')->get();

        // Retorna JSON para que JS pueda usarlo
        return response()->json($productos);
    }

    public function exportPdf()
    {
        $productos = Producto::all();
        $pdf = PDF::loadView('admin.productos.pdf', compact('productos'));
        return $pdf->download('Lista_Productos.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'Lista_Productos.xlsx');
    }
}
