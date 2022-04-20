<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'username' => 'required|min:3|max:25|unique:admins,username',
            'password' => 'required|min:3|max:25|',
        ]);


        Admin::create([
            'username' => Str::lower($request->username),
            'password' => bcrypt($request->password),
        ]);

        $admin = Admin::where('username', $request->username)->first();

        return response()->json([
            'message' => 'admin registration success',
            'admin' => $admin,
        ]);
    }
}
