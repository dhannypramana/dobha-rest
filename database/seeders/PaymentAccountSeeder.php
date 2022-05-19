<?php

namespace Database\Seeders;

use App\Models\PaymentAccount;
use Illuminate\Database\Seeder;

class PaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentAccount::create([
            'method' => 'bca',
            'payment_number' => '787878726267'
        ]);
        PaymentAccount::create([
            'method' => 'dana',
            'payment_number' => '123456789'
        ]);
        PaymentAccount::create([
            'method' => 'ovo',
            'payment_number' => '987654321'
        ]);
    }
}
