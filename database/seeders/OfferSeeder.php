<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $cards = Card::all();

        if ($users->isEmpty() || $cards->isEmpty()) {
            return;
        }

        $qualities = ['Mint', 'Near Mint', 'Excellent', 'Good', 'Light Played', 'Played', 'Poor'];

        $descriptions = [
            'Perfect condition card, never played',
            'Excellent condition, minimal wear',
            'Good condition with minor edge wear',
            'Light play condition, some scratches',
            'Moderate play wear visible',
            'Heavy play wear, still tournament legal',
            'Poor condition, collection only',
            'Fresh from pack, mint condition',
            'Stored in sleeves since opening',
            'Minor whitening on edges',
            'Some corner wear but clean surface',
            'Tournament played but well maintained',
            'Vintage card with expected wear',
            'Near mint with slight edge wear',
            'Excellent for casual play',
            'Good collector condition',
            'Well-loved card with character',
            'Tournament ready condition',
            'Premium condition card',
            'Classic card in great shape',
        ];

        // Create offers for random cards
        foreach (range(1, 50) as $i) {
            $user = $users->random();
            $card = $cards->random();
            $quality = $qualities[array_rand($qualities)];
            $description = $descriptions[array_rand($descriptions)];

            // Price based on quality
            $basePrice = fake()->randomFloat(2, 0.5, 100.0);
            $qualityMultiplier = match ($quality) {
                'Mint' => 1.5,
                'Near Mint' => 1.3,
                'Excellent' => 1.1,
                'Good' => 1.0,
                'Light Played' => 0.8,
                'Played' => 0.6,
                'Poor' => 0.3,
            };

            $price = round($basePrice * $qualityMultiplier, 2);
            $quantity = fake()->numberBetween(1, 3);

            DB::table('offers')->insertOrIgnore([
                'user_id' => $user->id,
                'card_id' => $card->id,
                'quality' => $quality,
                'description' => $description,
                'price' => $price,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create some specific high-value offers
        $premiumCards = $cards->take(5);
        foreach ($premiumCards as $card) {
            $user = $users->random();
            DB::table('offers')->insertOrIgnore([
                'user_id' => $user->id,
                'card_id' => $card->id,
                'quality' => 'Mint',
                'description' => 'Premium collector grade card',
                'price' => fake()->randomFloat(2, 50.0, 500.0),
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
