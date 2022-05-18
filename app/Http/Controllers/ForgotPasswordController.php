<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
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
        $request->validate([
            'token' => 'required',
            'password' => ['required', 'confirmed'],
            'email' => 'required'
        ]);

        $status = Password::reset(
            $request->only('password', 'password_confirmation', 'token'),
            function() use ($request) {
                $user = User::whereEmail($request->email)->first();
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return view('reset_success');
        }

        return view('token-reset-expired');
    }

    public function form_reset_password($token)
    {
        return view('form-reset-password', [
            'token' => $token,
        ]);
    }
}
