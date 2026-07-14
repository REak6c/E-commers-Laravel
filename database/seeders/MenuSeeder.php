<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menuId = DB::table('menus')->insertGetId([
            'title'      => 'Main Menu',
            'status'     => true,
            'date'       => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $items = [
            ['slug' => 'home',     'title' => 'Home',        'order_number' => 1],
            ['slug' => 'about',    'title' => 'About Us',    'order_number' => 2],
            ['slug' => 'services', 'title' => 'Our Services','order_number' => 3],
            ['slug' => 'blog',     'title' => 'Blog',        'order_number' => 4],
            ['slug' => 'contact',  'title' => 'Contact Us',  'order_number' => 5],
        ];

        foreach ($items as $item) {
            DB::table('menu_items')->insert([
                'menu_id'      => $menuId,
                'title'        => $item['title'],
                'slug'         => $item['slug'],
                'order_number' => $item['order_number'],
                'parent_id'    => null,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ]);
        }
    }
}
