<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Parfume'
        ]);
        Category::create([
            'name' => 'Hobby'
        ]);
        Category::create([
            'name' => 'Lifestyle'
        ]);
        Category::create([
            'name' => 'Feminin'
        ]);
    }
}
