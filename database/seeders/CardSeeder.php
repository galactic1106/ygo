<?php

namespace Database\Seeders;

use App\Services\YgoApiProxyService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ygoService = app(YgoApiProxyService::class);

        // Get some popular monsters
        $monsters = $ygoService->getCardData([
            'type' => 'Effect Monster',
            'sort' => 'atk',
            'num' => 30,
            'offset' => 0,
        ]);

        // Get some spell cards
        $spells = $ygoService->getCardData([
            'type' => 'Spell Card',
            'sort' => 'name',
            'num' => 20,
            'offset' => 0,
        ]);

        // Get some trap cards
        $traps = $ygoService->getCardData([
            'type' => 'Trap Card',
            'sort' => 'name',
            'num' => 15,
            'offset' => 0,
        ]);

        // Get some extra deck monsters
        $extraDeck = $ygoService->getCardData([
            'type' => implode(',', ['Fusion Monster', 'Synchro Monster', 'XYZ Monster', 'Link Monster']),
            'sort' => 'new',
            'num' => 25,
            'offset' => 0,
        ]);

        // Insert cards into database
        $this->insertCards($monsters['data'] ?? []);
        $this->insertCards($spells['data'] ?? []);
        $this->insertCards($traps['data'] ?? []);
        $this->insertCards($extraDeck['data'] ?? []);
    }

    /**
     * Insert cards into the database
     */
    private function insertCards(array $cardData): void
    {
        $cardsToInsert = [];
        foreach ($cardData as $cardInfo) {
            $cardId = (string) $cardInfo['id'];
            $cardsToInsert[] = ['id' => $cardId];
        }

        // Use batch insert to avoid duplicates
        DB::table('cards')->insertOrIgnore($cardsToInsert);
    }
}
