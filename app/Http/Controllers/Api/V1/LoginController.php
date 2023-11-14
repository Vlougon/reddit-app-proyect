<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if (Auth::user()->hasVerifiedEmail()) {

                $token = $user->createToken('MyApp')->accessToken;
                return response()->json([
                    'message' => 'User loged successfully.',
                    'token' => $token
                ], 200);
                
            } else {
                return response()->json(['message' => 'Your Email is not verified, try again after you verfy it.'], 403);
            }
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
