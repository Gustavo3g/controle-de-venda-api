<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json(compact('orders'), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only('user_id', 'items_id', 'client_id');
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'client_id' => 'required',
            'items_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        if (!$user = User::find($request->get('user_id')) or
            !$client = Client::find($request->get('client_id'))
        ) {
            $valid = empty($user->id) ? 'user_error' : 'client_error';

            switch ($valid) {
                case 'user_error':
                    return response()->json(['success' => false, 'message' => 'User not found'], Response::HTTP_BAD_REQUEST);
                case 'client_error':
                    return response()->json(['success' => false, 'message' => 'Client not found'], Response::HTTP_BAD_REQUEST);
            }
        }


        $items = count(explode(',', $request->items_id)) > 1 ? explode(',', $request->get('items_id')) : $request->get('items_id');
        $total_amount = 0;
        foreach ($items as $item) {

            if (!$product = Product::find($item)) {
                return response()->json(['success' => false, 'message' => "Product with id {$item} not found"], Response::HTTP_BAD_REQUEST);
            }

            $total_amount += (float)$product->value;

        }

        Order::create([
            'user_id' => $request->get('user_id'),
            'client_id' => $request->get('client_id'),
            'items_id' => $request->get('items_id'),
            'total_amount' => $total_amount,
        ]);

        return response()->json(['success' => true, 'message' => "Order created successfully"], Response::HTTP_BAD_REQUEST);


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $data = $request->only('user_id', 'items_id', 'client_id', 'total_amount');
        $validator = Validator::make($data, [
            'user_id' => 'required',
            'client_id' => 'required',
            'items_id' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        if (!$order = Order::find($id)) {
            return response()->json(['success' => false, 'message' => 'Order not found'], Response::HTTP_BAD_REQUEST);
        }

        $order->update([
            'user_id' => $request->get('user_id') ?? $order->user_id,
            'client_id' => $request->get('client_id') ?? $order->id,
            'items_id' => $request->get('items_id') ?? $order->items_id,
            'total_amount' => $request->get('total_amount') ?? $order->total_amount,
        ]);

        return response()->json(['success' => true, 'message' => "Order edited successfully"], Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!$order = Order::find($id)) {
            return response()->json(['success' => false, 'message' => "Order not found"], Response::HTTP_BAD_REQUEST);
        }

        $order->delete();

        return response()->json(['success' => true, 'message' => "Order deleted"], Response::HTTP_OK);
    }

}
