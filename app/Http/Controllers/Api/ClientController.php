<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::all();

        return response()->json(['success' => true, 'clients' => $clients]);
    }

    public function store(Request $request)
    {
        $data = $request->only('name', 'cpf', 'birth_date');

        $validator = Validator::make($data, [
            'name' => 'required|string',
            'cpf' => 'required|min:11',
            'birth_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        Client::create([
            'name' => $request->get('name'),
            'cpf' => $request->get('cpf'),
            'birth_date' => $request->get('birth_date'),
        ]);

        return response()->json(['success' => true, 'message' => 'Client created successfully'], Response::HTTP_OK);
    }

    public function show($id)
    {
        if (!$client = Client::find($id)){
            return response()->json(['success' => false, 'message' => 'Client not found'],401);
        };

        return response()->json(compact('client'));
    }
}
