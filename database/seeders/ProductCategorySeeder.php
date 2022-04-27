<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'name' => 'Uncategorized'
        ]);
        ProductCategory::create([
            'name' => 'Parfume laki laki'
        ]);
        ProductCategory::create([
            'name' => 'Parfume wanita'
        ]);
        ProductCategory::create([
            'name' => 'Parfume maskulin'
        ]);
        ProductCategory::create([
            'name' => 'Parfume Feminin'
        ]);
    }
}
