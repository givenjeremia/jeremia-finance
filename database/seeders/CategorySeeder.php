<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Gaji', 'type' => 'income'],
            ['name' => 'Freelance', 'type' => 'income'],
            ['name' => 'Investasi', 'type' => 'income'],
        
            ['name' => 'Makan', 'type' => 'expense'],
            ['name' => 'Transport', 'type' => 'expense'],
            ['name' => 'Belanja', 'type' => 'expense'],
            ['name' => 'Tagihan', 'type' => 'expense'],
        ]);
    }
}
