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
    public function getone($id)
    {
        $product = Products::find(id);
        if (!student){
        $data = [
            'message'=> 'Estudiante no encontrado',
            'status' => 404
        ];
        return response ()->json($data,404);
    }
    $data = [
        'student' =>$student,
        'status' =>200
        ];
        return response()->json($data,404);

    }

}
