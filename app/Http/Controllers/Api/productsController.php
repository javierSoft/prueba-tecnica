<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productsController extends Controller
{
    public function index ()
    {
       $products = Products::all();

       if ($products->isEmpty()){
        return response()->json(['message'=>'No hay productos registrados'],200);
       }
        return response()->json($products,200);
    }
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
