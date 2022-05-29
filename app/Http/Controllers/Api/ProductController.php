<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Product;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();

        return response()->json(compact('products'), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'lote_id', 'description', 'value', 'color');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'color' => 'required|string',
            'description' => 'required',
            'value' => 'required',
            'lote_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        if (!$lote = Lote::find($request->get('lote_id'))) {
            return response()->json(['success' => false, 'message' => 'Lote not found'], Response::HTTP_BAD_REQUEST);
        }

        Product::create([
            'name' => $request->get('name'),
            'color' => $request->get('color'),
            'description' => $request->get('description'),
            'value' => $request->get('value'),
            'lote_id' => $request->get('lote_id')
        ]);

        return response()->json(['success' => true, 'message' => 'Product created successfully'], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (!$product = Product::find($id)) {
            return response()->json(['success' => false, 'message' => 'Sorry, product not found.'], 400);
        }

        return response()->json(compact('product'), 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('name', 'color', 'description', 'value');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'color' => 'required',
            'description' => 'required',
            'value' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        if (!$product = Product::find($id)) {
            return response()->json(['success' => false, 'message' => 'Product not found'], Response::HTTP_BAD_REQUEST);
        }

        $product->update([
            'name' => $request->get('name'),
            'color' => $request->get('color'),
            'description' => $request->get('description'),
            'value' => $request->get('value'),
        ]);

        return response()->json(['success' => true, 'message' => 'Product updated successfully'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!$product = Product::find($id)) {
            return response()->json(['success' => false, 'message' => 'Product not found'], Response::HTTP_BAD_REQUEST);
        }
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully'], Response::HTTP_OK);
    }

}
