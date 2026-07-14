<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SiteSettingsSeeder::class,
            AdminSeeder::class,
            CurrencySeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            AttributeSeeder::class,
            BannerSeeder::class,
            PageSeeder::class,
            MenuSeeder::class,
            ThemeSeeder::class,
            ProductSeeder::class,
            PaymentGatewaySeeder::class,
            PaymentGatewayConfigSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class,
            RefundSeeder::class,
        ]);
    }
}
