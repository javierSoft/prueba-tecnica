<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="API de Productos y Órdenes",
 *         version="1.0.0",
 *         description="Documentación  de la API, incluyendo los endpoints de gestión de productos y órdenes.",
 *
 *
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000",
 *         description="Servidor local de desarrollo"
 *     ),
 *     @OA\Server(
 *         url="https://api.example.com",
 *         description="Servidor de producción"
 *     ),
 *
 * )
 *
 * @OA\Tag(
 *     name="Productos",
 *     description="Endpoints para la gestión de productos"
 * )
 *
 * @OA\Tag(
 *     name="Órdenes",
 *     description="Endpoints para la gestión de órdenes"
 * )
 */

class OrderController extends Controller
{
    /**
 * Crear una nueva orden
 *
 * @OA\Post(
 *     path="/api/ordenes",
 *     tags={"Órdenes"},
 *     summary="Crear una nueva orden",
 *     description="Este endpoint permite crear una nueva orden con información del cliente y el estado inicial.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="customer_name",
 *                 type="string",
 *                 description="Nombre del cliente",
 *                 example="Juan Pérez"
 *             ),
 *             @OA\Property(
 *                 property="customer_email",
 *                 type="string",
 *                 description="Correo electrónico del cliente",
 *                 example="juan.perez@example.com"
 *             ),
 *             @OA\Property(
 *                 property="total_price",
 *                 type="number",
 *                 description="Precio total de la orden",
 *                 example=199.99
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="Estado inicial de la orden",
 *                 enum={"pending", "completed", "canceled"},
 *                 example="pending"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Orden creada con éxito",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Orden creada con éxito"
 *             ),
 *             @OA\Property(
 *                 property="order",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     example=1
 *                 ),
 *                 @OA\Property(
 *                     property="customer_name",
 *                     type="string",
 *                     example="Juan Pérez"
 *                 ),
 *                 @OA\Property(
 *                     property="customer_email",
 *                     type="string",
 *                     example="juan.perez@example.com"
 *                 ),
 *                 @OA\Property(
 *                     property="total_price",
 *                     type="number",
 *                     example=199.99
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="string",
 *                     example="pending"
 *                 ),
 *                 @OA\Property(
 *                     property="order_date",
 *                     type="string",
 *                     format="date-time",
 *                     example="2024-11-14T12:00:00Z"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=201
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validación de datos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Error en la validación de datos"
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 example={"customer_name": {"El campo nombre del cliente es requerido."}}
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="integer",
 *                 example=400
 *             )
 *         )
 *     )
 * )
 */
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

/**
 * Listar todas las órdenes
 *
 * @OA\Get(
 *     path="/api/ordenes",
 *     tags={"Órdenes"},
 *     summary="Obtener todas las órdenes",
 *     description="Este endpoint devuelve una lista de todas las órdenes registradas. Si no hay órdenes, retorna un mensaje indicando que no se encontraron registros.",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de órdenes o mensaje de que no hay órdenes",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     type="array",
 *                     description="Lista de órdenes",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(
 *                             property="id",
 *                             type="integer",
 *                             example=1
 *                         ),
 *                         @OA\Property(
 *                             property="customer_name",
 *                             type="string",
 *                             example="Juan Pérez"
 *                         ),
 *                         @OA\Property(
 *                             property="customer_email",
 *                             type="string",
 *                             example="juan.perez@example.com"
 *                         ),
 *                         @OA\Property(
 *                             property="total_price",
 *                             type="number",
 *                             example=199.99
 *                         ),
 *                         @OA\Property(
 *                             property="status",
 *                             type="string",
 *                             example="pending"
 *                         ),
 *                         @OA\Property(
 *                             property="order_date",
 *                             type="string",
 *                             format="date-time",
 *                             example="2024-11-14T12:00:00Z"
 *                         )
 *                     )
 *                 ),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(
 *                         property="message",
 *                         type="string",
 *                         example="No hay órdenes registradas"
 *                     ),
 *                     @OA\Property(
 *                         property="status",
 *                         type="integer",
 *                         example=200
 *                     )
 *                 )
 *             }
 *         )
 *     )
 * )
 */
    public function index()
    {
        $ordenes = Order::all();

        if ($ordenes->isEmpty()) {
            return response()->json([
                'message' => 'No hay órdenes registradas',
                'status' => 200,
            ], 200);
        }

        return response()->json($ordenes, 200);
    }
/**
 * Obtener una orden específica
 *
 * @OA\Get(
 *     path="/api/ordenes/{id}",
 *     tags={"Órdenes"},
 *     summary="Obtener una orden específica",
 *     description="Este endpoint permite obtener la información de una orden específica utilizando su ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden a consultar",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orden encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="order",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="customer_name", type="string", example="Juan Pérez"),
 *                 @OA\Property(property="customer_email", type="string", example="juan.perez@example.com"),
 *                 @OA\Property(property="total_price", type="number", example=199.99),
 *                 @OA\Property(property="status", type="string", example="pending"),
 *                 @OA\Property(property="order_date", type="string", format="date-time", example="2024-11-14T12:00:00Z")
 *             ),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Orden no encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Orden no encontrada"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */
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
/**
 * Actualizar una orden existente
 *
 * @OA\Put(
 *     path="/api/ordenes/{id}",
 *     tags={"Órdenes"},
 *     summary="Actualizar una orden existente",
 *     description="Este endpoint permite actualizar los datos de una orden específica.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden a actualizar",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="customer_name",
 *                 type="string",
 *                 description="Nombre del cliente",
 *                 example="Juan Pérez"
 *             ),
 *             @OA\Property(
 *                 property="customer_email",
 *                 type="string",
 *                 description="Correo electrónico del cliente",
 *                 example="juan.perez@example.com"
 *             ),
 *             @OA\Property(
 *                 property="total_price",
 *                 type="number",
 *                 description="Precio total de la orden",
 *                 example=199.99
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 description="Estado de la orden",
 *                 enum={"pending", "completed", "canceled"},
 *                 example="completed"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orden actualizada con éxito",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Orden actualizada con éxito"),
 *             @OA\Property(
 *                 property="order",
 *                 type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="customer_name", type="string", example="Juan Pérez"),
 *                 @OA\Property(property="customer_email", type="string", example="juan.perez@example.com"),
 *                 @OA\Property(property="total_price", type="number", example=199.99),
 *                 @OA\Property(property="status", type="string", example="completed"),
 *                 @OA\Property(property="order_date", type="string", format="date-time", example="2024-11-14T12:00:00Z")
 *             ),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validación de datos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error en la validación de datos"),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 example={"customer_name": {"El campo nombre del cliente es requerido."}}
 *             ),
 *             @OA\Property(property="status", type="integer", example=400)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Orden no encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Orden no encontrada"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */

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
/**
 * Eliminar una orden
 *
 * @OA\Delete(
 *     path="/api/ordenes/{id}",
 *     tags={"Órdenes"},
 *     summary="Eliminar una orden",
 *     description="Este endpoint permite eliminar una orden existente por su ID.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden a eliminar",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orden eliminada con éxito",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Orden eliminada con éxito"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Orden no encontrada",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Orden no encontrada"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */

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
