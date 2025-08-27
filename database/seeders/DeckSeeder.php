<?php

namespace Database\Seeders;

use App\Models\Deck;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return;
        }

        $deckNames = [
            'Blue-Eyes White Dragon Deck',
            'Dark Magician Control',
            'Elemental HERO Fusion',
            'Dragon Ruler Control',
            'Sky Striker Tempo',
            'Salamangreat Combo',
            'True Draco Control',
            'Eldlich Control',
            'Tri-Brigade Zoo',
            'Virtual World Synchro',
            'Prank-Kids Combo',
            'Cyber Dragon OTK',
            'Blackwing Synchro',
            'Six Samurai Aggro',
            'Zombie World Control',
        ];

        $notes = [
            'Competitive tournament deck',
            'Casual fun deck for locals',
            'Work in progress build',
            'Meta tier 1 build',
            'Budget friendly version',
            'Experimental combo deck',
            'Classic nostalgic build',
            'Anti-meta control deck',
        ];

        $decksToInsert = [];
        foreach ($deckNames as $name) {
            $user = $users->random();
            $decksToInsert[] = [
                'name' => $name,
                'user_id' => $user->id,
                'notes' => $notes[array_rand($notes)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('decks')->insertOrIgnore($decksToInsert);

        // Create additional random decks
        for ($i = 0; $i < 10; $i++) {
            Deck::factory()->create([
                'user_id' => $users->random()->id,
            ]);
        }
    }
}
