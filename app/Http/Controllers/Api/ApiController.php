<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password', 'cpf');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
            'cpf' => 'required|min:11'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'cpf' => $request->get('cpf'),
            'password' => bcrypt($request->get('password'))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], Response::HTTP_OK);
        }

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (JWTException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'bearer_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {

        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
