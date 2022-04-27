<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdatePasswordController extends Controller
{
    public function update_form($token)
    {
        return view('form-reset-password', [
            'token' => $token
        ]);
    }

    public function reset_password()
    {
        
    }
}
