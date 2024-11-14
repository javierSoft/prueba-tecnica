<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productsController extends Controller
{
/**
 * Listar todos los productos
 *
 * @OA\Get(
 *     path="/api/productos",
 *     tags={"Productos"},
 *     summary="Obtener todos los productos",
 *     description="Este endpoint devuelve una lista de todos los productos registrados. Si no hay productos, retorna un mensaje indicando que no se encontraron registros.",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de productos o mensaje de que no hay productos",
 *         @OA\JsonContent(
 *             oneOf={
 *                 @OA\Schema(
 *                     type="array",
 *                     description="Lista de productos",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="id", type="integer", example=1),
 *                         @OA\Property(property="name", type="string", example="Producto A"),
 *                         @OA\Property(property="category", type="string", example="Electrónica"),
 *                         @OA\Property(property="description", type="string", example="Descripción del producto"),
 *                         @OA\Property(property="amount", type="number", example=10)
 *                     )
 *                 ),
 *                 @OA\Schema(
 *                     type="object",
 *                     @OA\Property(property="message", type="string", example="No hay productos registrados"),
 *                     @OA\Property(property="status", type="integer", example=200)
 *                 )
 *             }
 *         )
 *     )
 * )
 */
    public function index ()
    {
       $products = Products::all();

       if ($products->isEmpty()){
        return response()->json(['message'=>'No hay productos registrados'],200);
       }
        return response()->json($products,200);
    }
/**
 * Crear un nuevo producto
 *
 * @OA\Post(
 *     path="/api/productos",
 *     tags={"Productos"},
 *     summary="Crear un producto",
 *     description="Este endpoint permite crear un nuevo producto. Requiere los campos 'name', 'category', 'description' y 'amount'. Devuelve el producto creado o un error en caso de fallo en la validación o creación.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Producto A"),
 *             @OA\Property(property="category", type="string", example="Electrónica"),
 *             @OA\Property(property="description", type="string", example="Descripción del producto"),
 *             @OA\Property(property="amount", type="number", example=10)
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Producto creado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="products", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Producto A"),
 *                 @OA\Property(property="category", type="string", example="Electrónica"),
 *                 @OA\Property(property="description", type="string", example="Descripción del producto"),
 *                 @OA\Property(property="amount", type="number", example=10)
 *             ),
 *             @OA\Property(property="status", type="integer", example=201)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Error en la validación de datos",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error en la validación de datos"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="El campo name es obligatorio.")
 *                 ),
 *                 @OA\Property(property="category", type="array",
 *                     @OA\Items(type="string", example="El campo category es obligatorio.")
 *                 ),
 *                 @OA\Property(property="description", type="array",
 *                     @OA\Items(type="string", example="El campo description es obligatorio.")
 *                 ),
 *                 @OA\Property(property="amount", type="array",
 *                     @OA\Items(type="string", example="El campo amount debe ser un número.")
 *                 )
 *             ),
 *             @OA\Property(property="status", type="integer", example=400)
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error al crear el producto",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Error al crear el producto"),
 *             @OA\Property(property="status", type="integer", example=500)
 *         )
 *     )
 * )
 */

    public function store (Request $request)
    {
        $validator = validator::make($request->all(),[

            'name'=> 'required',
            'category'=> 'required',
            'description'=> 'required',
            'amount'=> 'required|numeric'

        ]);
        if ($validator->fails()) {
            $data =[
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' =>400
        ];
            return response()->json($data,400);
        }
        $products = Products::create([
            'name'=> $request->name,
            'category'=> $request->category,
            'description'=> $request->description,
            'amount'=> $request->amount
        ]);
        if (!$products){
            $data= [
                'message' => 'Error al crear el producto',
                'status' => 500,
            ];
            return response ()->json($data,500);
        }
        $data=[
            'products'=>$products,
            'status'=>201
        ];
        return response()->json($data,201);
    }
/**
 * Obtener detalles de un producto
 *
 * @OA\Get(
 *     path="/api/productos/{id}",
 *     tags={"Productos"},
 *     summary="Obtener un producto por ID",
 *     description="Este endpoint permite obtener los detalles de un producto específico utilizando su ID. Devuelve el producto encontrado o un mensaje de error si no existe.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del producto",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Producto encontrado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="product", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Producto A"),
 *                 @OA\Property(property="category", type="string", example="Electrónica"),
 *                 @OA\Property(property="description", type="string", example="Descripción del producto"),
 *                 @OA\Property(property="amount", type="number", example=10)
 *             ),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Producto no encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */

    public function show($id)
    {
        $product = Products::find($id);

        if (!$product){
            $data = [
                'message'=> 'Producto no encontrado',
                'status' => 404
        ];
        return response ()->json($data,404);
    }
    $data = [
        'product' =>$product,
        'status' =>200
        ];
        return response()->json($data,200);

    }

/**
 * Eliminar un producto
 *
 * @OA\Delete(
 *     path="/api/productos/{id}",
 *     tags={"Productos"},
 *     summary="Eliminar un producto por ID",
 *     description="Este endpoint permite eliminar un producto específico utilizando su ID. Devuelve un mensaje de éxito si el producto fue eliminado o un mensaje de error si no se encuentra el producto.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del producto a eliminar",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Producto eliminado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Producto eliminado"),
 *             @OA\Property(property="status", type="integer", example=200)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Producto no encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */

    public function eliminate($id)
    {
        $product = Products::find($id);

        if (!$product){
            $data = [
                'message'=> 'Producto no encontrado',
                'status' => 404
        ];
        return response ()->json($data,404);
    }

    $product->delete();

    $data =[
        'message' => 'Producto eliminado',
        'status'  =>200
    ];
    return response ()->json($data,200);

    }
/**
 * Actualizar un producto
 *
 * @OA\Put(
 *     path="/api/productos/{id}",
 *     tags={"Productos"},
 *     summary="Actualizar un producto por ID",
 *     description="Este endpoint permite actualizar los detalles de un producto específico utilizando su ID. Requiere los campos 'name', 'category', 'description' y 'amount'. Devuelve el producto actualizado o un error en caso de fallo en la validación o si el producto no existe.",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del producto a actualizar",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="name", type="string", example="Producto A"),
 *             @OA\Property(property="category", type="string", example="Electrónica"),
 *             @OA\Property(property="description", type="string", example="Descripción del producto"),
 *             @OA\Property(property="amount", type="number", example=20)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Producto actualizado exitosamente",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Producto actualizado"),
 *             @OA\Property(property="product", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="name", type="string", example="Producto A"),
 *                 @OA\Property(property="category", type="string", example="Electrónica"),
 *                 @OA\Property(property="description", type="string", example="Descripción del producto actualizado"),
 *                 @OA\Property(property="amount", type="number", example=20)
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
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="name", type="array",
 *                     @OA\Items(type="string", example="El campo name es obligatorio.")
 *                 ),
 *                 @OA\Property(property="category", type="array",
 *                     @OA\Items(type="string", example="El campo category es obligatorio.")
 *                 ),
 *                 @OA\Property(property="description", type="array",
 *                     @OA\Items(type="string", example="El campo description es obligatorio.")
 *                 ),
 *                 @OA\Property(property="amount", type="array",
 *                     @OA\Items(type="string", example="El campo amount debe ser un número.")
 *                 )
 *             ),
 *             @OA\Property(property="status", type="integer", example=400)
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Producto no encontrado",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
 *             @OA\Property(property="status", type="integer", example=404)
 *         )
 *     )
 * )
 */

    public function update(Request $request,$id)
    {
        $product = Products::find($id);

        if (!$product){
            $data = [
                'message'=> 'Producto no encontrado',
                'status' => 404
        ];
        return response ()->json($data,404);
    }

    $validator = validator::make($request->all(),[

        'name'=> 'required',
        'category'=> 'required',
        'description'=> 'required',
        'amount'=> 'required|numeric'
    ]);
    if ($validator->fails()) {
        $data =[
            'message' => 'Error en la validación de datos',
            'errors' => $validator->errors(),
            'status' =>400
        ];
        return response()->json($data,400);
    }

    $product->name = $request->name;
    $product->category = $request->category;
    $product->description = $request->description;
    $product->amount = $request->amount ;

    $product->save();

    $data = [
        'message' => 'Producto actualizado',
        'product'=> $product,
        'status' => 200
    ];

    return response()->json($data,200);
    }
}
