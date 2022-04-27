<?php

namespace App\Http\Controllers\Auth\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;

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
                ], 401);
            }
    
            $user->update([
                'alamat' => $request->alamat,
                'provinsi' => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'id_kabupaten' => $request->id_kabupaten,
            ]);
    
            return response()->json([
                'message' => 'update user address success',
                'user' => $user,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function update_user(Request $request, User $user)
    {
        try {
            if (auth()->user()->username !== $user->username) {
                return response()->json([
                    'message' => 'unauthorized'
                ], 401);
            }

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);

            return response()->json([
                'message' => 'update user success',
                'user' => $user,
            ], 200);
        } catch (QueryException $qe) {
            return response()->json([
                'error' => 'failed' . $qe->getMessage()
            ]);
        }
    }

    public function update_photo(Request $request)
    {
        return 'Hello';
        return $request->all();
    }
}
