<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Admin $admin)
    {
        try {
            $admin->delete();

            return response()->json([
                'message' => 'success delete admin'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e
            ]);
        }
    }
}
