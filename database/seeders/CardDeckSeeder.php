<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Deck;
use Illuminate\Database\Seeder;

class CardDeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $decks = Deck::all();
        $cards = Card::all();
        
        if ($decks->isEmpty() || $cards->isEmpty()) {
            return;
        }

        foreach ($decks as $deck) {
            // Add random cards to each deck (typical deck has 40-60 cards)
            $deckSize = fake()->numberBetween(40, 60);
            $selectedCards = $cards->random($deckSize);
            
            foreach ($selectedCards as $card) {
                // Some cards might be played in multiples (1-3 copies)
                $quantity = fake()->numberBetween(1, 3);
                
                // Check if this card is already in the deck to avoid duplicates
                if (!$deck->cards()->where('card_id', $card->id)->exists()) {
                    $deck->cards()->attach($card->id, ['quantity' => $quantity]);
                }
            }
        }

        // Ensure each deck has at least 20 cards
        foreach ($decks as $deck) {
            $currentCount = $deck->cards()->sum('card_deck.quantity');
            if ($currentCount < 20) {
                $additionalCards = $cards->random(20 - $currentCount);
                foreach ($additionalCards as $card) {
                    if (!$deck->cards()->where('card_id', $card->id)->exists()) {
                        $deck->cards()->attach($card->id, ['quantity' => 1]);
                    }
                }
            }
        }
    }
}
