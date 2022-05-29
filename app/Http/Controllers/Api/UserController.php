<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserController extends Controller
{

    public function index()
    {
        $user = $this->user();

        return response()->json(compact('user'));
    }

    public function store(Request $request)
    {
       //
    }

    public function update(Request $request, $id)
    {
        if (!$user = User::find($id)){
            return response()->json(['success' => false, 'message' => 'User not found'],401);
        }
        $data = $request->only('name', 'email', 'cpf', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'cpf' => 'required|min:11',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'cpf' => $request->get('cpf'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json(['success' => true, 'message' => 'User edited successfully']);
    }

    public function show($id)
    {
        if (!$user = User::find($id)){
            return response()->json(['success' => false, 'message' => 'User not found'],401);
        };

        return response()->json(compact('user'));
    }

    public function destroy($id)
    {
        if (!$user = User::find($id)){
            return response()->json(['success' => false, 'message' => 'User not found'],401);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User successfully deleted']);
    }

    protected function user() {
        return JWTAuth::parseToken()->authenticate();
    }

}
