<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu_id = DB::table('menus')->insertGetId([
            'name' => 'Main',
            'status' => 1
        ]);

        DB::table('menu_items')->insert([
            'name' => 'Coffee',
            'menu_id' => $menu_id,
            'image' => 'menu-items/coffee.jpg',
            'original_price' => 2.99,
            'price' => 2.5,
            'status' => 1
        ]);
    }
}
