<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

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
        try {
            if (auth()->user()->username !== $user->username) {
                return response()->json([
                    'message' => 'unauthorized'
                ]);
            }
    
            $request->validate([
                'alamat' => 'required|min:3|max:25',
                'provinsi' => 'required|min:3|max:25',
                'kabupaten' => 'required|min:3|max:25',
                'id_kabupaten' => 'required'
            ]);
    
            $user->update([
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'id_kabupaten' => $request->id_kabupaten,
            ]);
    
            return response()->json([
                'message' => 'update user success',
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
