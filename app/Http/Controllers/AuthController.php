<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Datos incorrectos', 'status' => false], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi '.$user->name,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' =>$user,
                'status' => true
            ]);
    }

    public function logout(Request $request)
    {
        // auth()->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' =>'You have successfully logged out and the token was successfully deleted',
            'status' => true,                
        ],200);

    }
}
