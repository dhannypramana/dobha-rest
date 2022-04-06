<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        if (auth()->user()->username !== $user->username) {
            return response()->json([
                'message' => 'unauthorized'
            ]);
        }

        $request->validate([
            'name' => 'required|min:3|max:25',
            'email' => 'required|min:3|max:25',
            'password' => 'required|min:3|max:25',
            'phone_number' => 'required|min:11'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'alamat' => $request->alamat
        ]);

        return response()->json([
            'message' => 'update user success',
            'user' => $user,
        ]);
    }
}
