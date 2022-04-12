<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins-api');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $request->user()->username;
    }

    public function index()
    {
        $admin = Admin::whereNotIn('id', [auth('admins-api')->id(1)])->get();

        return response()->json([
            'message' => 'success',
            'admin' => $admin
        ]);
    }

    public function show(Admin $admin)
    {
        return response()->json([
            'message' => 'success',
            'admin' => $admin
        ]);
    }
}
