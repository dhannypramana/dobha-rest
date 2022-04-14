<?php

namespace App\Http\Controllers\Auth\User;

use Exception;
use App\Models\User;
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
            'email' => 'required|min:3|max:25|unique:users,email',
            'password' => 'required|min:8|max:20|',
            'phone_number' => 'required|min:11'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
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
