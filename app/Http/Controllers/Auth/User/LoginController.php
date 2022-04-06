<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
            return response(null, 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'login success',
            'user' => $user,
            'token' => $token
        ]);
    }
}
