<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Delivery;
use App\Models\Payment;

class Pedidosp extends Controller
{
    // Página posterior al login
    public function finalizarPedido()
    {
        return view('vistapublica.procesocarrito');
    }

    // Vista del checkout
    public function mostrarFormularioCheckout()
    {
        return view('vistapublica.checkout');
    }

    // Procesa y guarda el pedido
    public function guardarPedido(Request $request)
    {
        $user = Auth::user();

        $productos = json_decode($request->productos, true);
        if (!$productos || count($productos) === 0) {
            return response()->json(['success' => false, 'message' => 'No hay productos.']);
        }

        $total = array_reduce($productos, fn($sum, $item) => $sum + ($item['precio'] * $item['cantidad']), 0);

        // Crear el pedido (tabla orders)
        $order = new Order();
        $order->user_id = $user->id;
        $order->total = $total;
        $order->estado = 'pendiente';
        $order->fecha = now(); // campo 'fecha' según tu base
        $order->save();

        // Guardar cada ítem del pedido (tabla order_items)
        foreach ($productos as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio']
            ]);
        }

        // Guardar método de entrega (tabla deliveries)
        $tipo = $request->delivery_method;
        $data = json_decode($request->delivery_data, true);

        $delivery = new Delivery();
        $delivery->order_id = $order->id;
        $delivery->tipo_entrega = $tipo;

        if ($tipo === 'delivery') {
            $delivery->direccion = $data['direccion'] . ' ' . $data['numero'] . ' (' . $data['referencia'] . ')';
            $delivery->ubicacion = $data['distrito'];
        } elseif ($tipo === 'recojo') {
            $delivery->direccion = $data['sede'];
            $delivery->fecha_entrega = $data['fecha'] . ' ' . $data['hora'];
        } elseif ($tipo === 'provincia') {
            $delivery->direccion = $data['empresa'];
            $delivery->ubicacion = $data['departamento'] . ' / ' . $data['provincia'] . ' / ' . $data['distrito'];
        }

        $delivery->save();

        // Guardar el pago (tabla payments)
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->metodo = $request->payment_method;
        $payment->codigo_operacion = $request->payment_code;
        $payment->fecha_pago = $request->payment_date;

        if ($request->hasFile('comprobante')) {
            $payment->imagen_voucher = $request->file('comprobante')->store('comprobantes', 'public');
        }

        $payment->save();

        return response()->json(['success' => true, 'message' => 'Pedido registrado correctamente']);
    }

    public function pedidosJson()
    {
        $pedidos = Order::with('items.product') // Asegúrate de tener la relación
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($pedidos);
    }
}
