<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductosExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection()
    {
        // Trae los productos con la categoría para mostrar nombre en lugar de id
        return Producto::with('categoria')
            ->get()
            ->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'descripcion_corta' => $producto->descripcion_corta,
                    'precio' => $producto->precio,
                    'precio_descuento' => $producto->precio_descuento,
                    'categoria' => $producto->categoria ? $producto->categoria->nombre : 'Sin categoría',
                    'stock' => $producto->stock,
                    'estado' => $producto->estado,
                ];
            });
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Descripción', 'Precio', 'Descuento', 'Categoría', 'Stock', 'Estado'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Lista de Productos';
    }
}
