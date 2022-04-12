<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin;
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
    public function __invoke(Request $request, Admin $admin)
    {
        try {
            $request->validate([
                'username' => 'required|min:3|max:25',
            ]);

            $admin->update([
                'username' => $request->username,
            ]);

            return response()->json([
                'message' => 'success update admin',
                'data' => $admin
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }
}
