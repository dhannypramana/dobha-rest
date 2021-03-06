<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'code' => '401',
                'error' => 'email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'login success',
            'user' => $user,
            'expired_token' => 1 /* JWT TTL */ * 60000,
            'expired_token_timestamp' => strtotime("+60 minutes"),
            // 'expired_token' => strtotime('now + 1 minutes'),
            'token' => $token
        ], 200);
    }
}
