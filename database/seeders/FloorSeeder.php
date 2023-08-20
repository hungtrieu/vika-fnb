<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Floor;

class FloorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $floor_id = DB::table('floors')->insertGetId([
            'name' => 'Floor 01',
        ]);

        DB::table('culinary_tables')->insert([
            'name' => 'Table 01',
            'floor_id' => $floor_id
        ]);

        DB::table('culinary_tables')->insert([
            'name' => 'Table 02',
            'floor_id' => $floor_id
        ]);
        DB::table('culinary_tables')->insert([
            'name' => 'Table 03',
            'floor_id' => $floor_id
        ]);
    }
}
