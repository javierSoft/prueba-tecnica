<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Crear una nueva orden
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'total_price' => 'required|numeric',
            'status' => 'in:pending,completed,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $order = Order::create(array_merge($validator->validated(), ['order_date' => now()]));

        return response()->json([
            'message' => 'Orden creada con éxito',
            'order' => $order,
            'status' => 201,
        ], 201);
    }

    // Listar todas las órdenes
    public function index()
    {
        $orders = Order::all();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'No hay órdenes registradas',
                'status' => 200,
            ], 200);
        }

        return response()->json($orders, 200);
    }

    // Obtener una orden específica
    public function show($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Orden no encontrada',
                'status' => 404,
            ], 404);
        }

        return response()->json([
            'order' => $order,
            'status' => 200,
        ], 200);
    }

    // Actualizar una orden
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Orden no encontrada',
                'status' => 404,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => 'sometimes|string|max:255',
            'customer_email' => 'sometimes|email',
            'total_price' => 'sometimes|numeric',
            'status' => 'sometimes|in:pending,completed,canceled',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $order->update($validator->validated());

        return response()->json([
            'message' => 'Orden actualizada con éxito',
            'order' => $order,
            'status' => 200,
        ], 200);
    }

    // Eliminar una orden
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Orden no encontrada',
                'status' => 404,
            ], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Orden eliminada con éxito',
            'status' => 200,
        ], 200);
    }
}
