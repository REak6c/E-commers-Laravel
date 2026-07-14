<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $sizeId = DB::table('attributes')->insertGetId([
            'name'       => 'Size',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (['Small', 'Medium', 'Large'] as $size) {
            DB::table('attribute_values')->insert([
                'attribute_id' => $sizeId,
                'value'        => $size,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }

        $colorId = DB::table('attributes')->insertGetId([
            'name'       => 'Color',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach (['Red', 'Green', 'Blue', 'Black', 'White', 'Yellow'] as $color) {
            DB::table('attribute_values')->insert([
                'attribute_id' => $colorId,
                'value'        => $color,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
