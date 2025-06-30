<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Productos PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #aaa; padding: 5px; text-align: left; vertical-align: middle; }
        th { background-color: #eee; }
        img { max-width: 50px; max-height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <h2>Listado de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Descuento</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>
                    @if($producto->imagen_principal)
                        <img src="{{ asset($producto->imagen_principal) }}" alt="Imagen producto">
                    @else
                        Sin imagen
                    @endif
                </td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ Str::limit($producto->descripcion_corta, 50) }}</td>
                <td>{{ number_format($producto->precio, 2) }}</td>
                <td>{{ number_format($producto->precio_descuento, 2) }}</td>
                <td>{{ $producto->categoria_id }}</td>
                <td>{{ $producto->stock }}</td>
                <td>{{ $producto->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
