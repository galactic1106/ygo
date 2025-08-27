<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creditCards = [
            ['cvv' => '123', 'number' => '1234', 'expiration' => '2025-12-31'],
            ['cvv' => '456', 'number' => '5678', 'expiration' => '2026-06-30'],
            ['cvv' => '789', 'number' => '9012', 'expiration' => '2027-03-31'],
            ['cvv' => '321', 'number' => '3456', 'expiration' => '2025-09-30'],
            ['cvv' => '654', 'number' => '7890', 'expiration' => '2026-12-31'],
            ['cvv' => '987', 'number' => '1357', 'expiration' => '2028-01-31'],
            ['cvv' => '147', 'number' => '2468', 'expiration' => '2027-08-31'],
            ['cvv' => '258', 'number' => '3691', 'expiration' => '2025-11-30'],
            ['cvv' => '369', 'number' => '4825', 'expiration' => '2026-04-30'],
            ['cvv' => '741', 'number' => '5936', 'expiration' => '2028-07-31'],
        ];

        DB::table('credit_cards')->insertOrIgnore($creditCards);

        // Create additional random credit cards
        CreditCard::factory(10)->create();
    }
}
