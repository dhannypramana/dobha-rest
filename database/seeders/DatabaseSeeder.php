<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Review;
use App\Models\PaymentAccount;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ProductCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(PaymentAccountSeeder::class);

        Admin::create([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin'),
        ]);
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);
    }
}
