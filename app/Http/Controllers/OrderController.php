<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new OrderCollection(Order::with('user')->with('products')->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Almacenar una orden
        $pedido = new Order;
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

        // Obtener Id de la orden
        $pedidoId = $pedido->id;

        // Obtener los productos del pedido
        $productos = $request->productos;


        // Formatear un arreglo
        $productosPedido = [];
        foreach ($productos as $producto) {
            $productosPedido[] = [
                'user_id' => Auth::user()->id,
                'order_id' => $pedidoId,
                'product_id' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        //Almacenar en la BD
        OrderProduct::insert($productosPedido);

        return [
            'message' => 'Realizando pedido correctamente, estará listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->estado = 1;
        $order->save();
        return [
            'message' => 'Pedido completado correctamente',
            'order' => $order
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
