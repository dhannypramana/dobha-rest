<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

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
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth('admins-api')->attempt($request->only('username', 'password'))) {
            return response(null, 401);
        }

        $admin = Admin::where('username', $request->username)->first();

        return response()->json([
            'message' => 'login success',
            'user' => $admin,
            'expired_token' => 120 /* JWT TTLK */ * 60000,
            'token' => $token
        ]);
    }
}
