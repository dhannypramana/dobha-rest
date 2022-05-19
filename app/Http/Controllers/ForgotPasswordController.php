<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as RulesPassword;

class ForgotPasswordController extends Controller
{
    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status)
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);
    }
    public function reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => ['required', 'min:8'],
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return view('email-not-found', [
                'error_status' => 422,
                'message' => 'password kurang dari 8 karakter'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if ($user === null) {
            return view('email-not-found', [
                'error_status' => 404,
                'message' => 'email not found'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        event(new PasswordReset($user));
        return view('reset_success');
    }

    public function form_reset_password($token)
    {
        return view('form-reset-password', [
            'token' => $token,
        ]);
    }
}
