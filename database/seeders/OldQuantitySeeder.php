<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OldQuantitySeeder extends Seeder
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

        // Create quantity history for some offers
        $oldQuantitiesToInsert = [];
        foreach ($offers->take(25) as $offer) {
            $numberOfChanges = fake()->numberBetween(1, 3);

            for ($i = 0; $i < $numberOfChanges; $i++) {
                // Generate different old quantities (usually higher)
                $quantityChange = fake()->numberBetween(0, 5);
                $oldQuantity = $offer->quantity + $quantityChange;

                $oldQuantitiesToInsert[] = [
                    'offer_id' => $offer->id,
                    'old_quantity' => $oldQuantity,
                    'created_at' => Carbon::now()->subDays(fake()->numberBetween(1, 60)),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('old_quantities')->insertOrIgnore($oldQuantitiesToInsert);
    }
}
