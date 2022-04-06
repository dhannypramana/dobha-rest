<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class RegisterController extends Controller
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
            'password' => 'required|min:3|max:25|',
            'password' => 'required|min:3|max:25|',
        ]);


        Admin::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        $admin = Admin::where('username', $request->username)->first();

        return response()->json([
            'message' => 'admin registration success',
            'admin' => $admin,
        ]);
    }
}
