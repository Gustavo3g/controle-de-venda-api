<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $lotes = Lote::all();

        return response()->json(compact('lotes'), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $products = $request->get('products');
            $quantity = count($products);

            DB::beginTransaction();

            $lote = Lote::create([
                'manufacturing_date' => date('Y-m-d H:i:s'),
                'quantity' => (string)$quantity,
            ]);

            foreach ($products as $product){

                //Validate data
                $validator = Validator::make($product, [
                    'name' => 'required',
                    'color' => 'required',
                    'description' => 'required|string',
                    'value' => 'required'
                ]);

                if ($validator->fails()) {
                    return response()->json(['success' => false, 'error' => $validator->messages()], 400);
                }

                Product::create([
                   'name' => $product['name'],
                   'color' => $product['color'],
                   'description' => $product['description'],
                   'value' => $product['value'],
                   'lote_id' => $lote->id
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Products created successfully'], 201);

        }catch (Throwable $exception) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $exception->getMessage()]) ;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (!$lote = Lote::find($id)){
            return response()->json(['success' => false, 'message' => 'Lote not found'],401);
        };

        return response()->json(compact('lote'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!$lote = Lote::find($id)){
            return response()->json(['success' => false, 'message' => 'Lote not found'],401);
        }

        $lote->delete();

        return response()->json(['success' => true, 'message' => 'Lote successfully deleted']);
    }
}
