<?php

namespace Database\Seeders;

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = Offer::all();

        if ($offers->isEmpty()) {
            return;
        }

        // Create price history for some offers
        $oldPricesToInsert = [];
        foreach ($offers->take(30) as $offer) {
            $numberOfChanges = fake()->numberBetween(1, 5);

            for ($i = 0; $i < $numberOfChanges; $i++) {
                // Generate a different old price (usually lower)
                $priceChange = fake()->randomFloat(2, -10.0, 5.0);
                $oldPrice = max(0.25, $offer->price + $priceChange);

                $oldPricesToInsert[] = [
                    'offer_id' => $offer->id,
                    'old_price' => $oldPrice,
                    'created_at' => Carbon::now()->subDays(fake()->numberBetween(1, 90)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('old_prices')->insertOrIgnore($oldPricesToInsert);
    }
}
