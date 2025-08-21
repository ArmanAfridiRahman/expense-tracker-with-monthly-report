<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(config('categories.expense_categories', []))
            ->each(fn($name) => Category::firstOrCreate(['name' => $name]));
    }
}
