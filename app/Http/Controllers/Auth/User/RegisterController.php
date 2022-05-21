<?php

namespace App\Http\Controllers\Auth\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;

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
            'name' => 'required|min:3|max:25',
            'username' => 'required|min:3|max:25|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8|max:20|',
            'phone_number' => 'required|min:11'
        ]);

        $user = User::create([
            'name' => Str::lower($request->name),
            'username' => Str::lower($request->username),
            'email' => Str::lower($request->email),
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number
        ]);

        event(new Registered($user));

        return response()->json([
            'message' => 'registration success',
            'verify' => 'verification email has been sent. please check the email that has been registered',
            'user' => $user,
        ], 200);
    }
}
