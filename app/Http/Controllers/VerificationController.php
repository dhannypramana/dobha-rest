<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    public function verify($id, $hash) {
        $user = User::find($id);
    
        abort_if(!$user, 403);
        abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())), 403);
    
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
    
        return response()->json([
            'message' => 'email telah di verifikasi'
        ], 200);
    }

    public function resend($id)
    {
        // return $id." ".auth()->user()->id;

        if (auth()->user()->id != $id) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'tidak ada user'
            ], 401);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'user sudah melakukan verifikasi email'
            ], 200);
        }

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'verifikasi email telah dikirim ulang'
        ], 200);
    }
}
