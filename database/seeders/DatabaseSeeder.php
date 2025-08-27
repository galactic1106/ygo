<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CardSeeder::class,
            CreditCardSeeder::class,
            OfferSeeder::class,
            DeckSeeder::class,
            CardDeckSeeder::class,
            OrderSeeder::class,
            OfferOrderSeeder::class,
            OldPriceSeeder::class,
            OldQuantitySeeder::class,
        ]);
    }
}
