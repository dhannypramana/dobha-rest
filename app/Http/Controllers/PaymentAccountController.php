<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentAccountCollection;
use Exception;

class PaymentAccountController extends Controller
{
    public function getAccount(Request $request)
    {
        if (! $request->has('method')) {
            $payment = PaymentAccount::get();
            return new PaymentAccountCollection($payment);
        }

        $payment = PaymentAccount::where('method', trim($request->method))->get();
        
        if (! $payment->isEmpty()) return new PaymentAccountCollection($payment);

        return response()->json([
            'error' => 'Methode tidak ditemukan'
        ], 404);
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'method' => 'required',
            'payment_number' => 'required|numeric'
        ]);
        
        $payment = PaymentAccount::where('method', $request->method)->first();
        
        if (!$payment) {
            return response()->json([
                'error' => 'Metode tidak ditemukan'
            ], 404);
        };

        try {
            $payment->update([
                'payment_number' => $request->payment_number
            ]);

            return response()->json([
                'status' => 'update nomor pembayaran sukses',
                'payment' => $payment
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
