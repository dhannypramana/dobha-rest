<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    */
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $request->user()->name;
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        try {
            return response()->json([
                'message' => 'get data user',
                'data' => $user
            ], Response::HTTP_OK);
        } catch (QueryException $qe) {
            return response()->json([
                'message' => 'failed' . $qe->errorInfo
            ]);
        }
    }
}
