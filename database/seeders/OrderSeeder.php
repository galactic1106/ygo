<?php

namespace Database\Seeders;

use App\Models\CreditCard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $creditCards = CreditCard::all();

        if ($users->isEmpty() || $creditCards->isEmpty()) {
            return;
        }

        $states = ['cart', 'processing', 'paid'];
        $countries = ['United States', 'Canada', 'United Kingdom', 'Germany', 'France', 'Japan', 'Australia'];
        $cities = ['New York', 'Los Angeles', 'Toronto', 'London', 'Berlin', 'Paris', 'Tokyo', 'Sydney'];
        $streets = ['Main St', 'Oak Ave', 'First St', 'Second Ave', 'Elm St', 'Maple Ave', 'Park Blvd', 'Cedar Ln'];

        // Create various orders in different states
        foreach (range(1, 25) as $i) {
            $state = $states[array_rand($states)];
            $user = $users->random();
            $creditCard = $creditCards->random();

            $orderData = [
                'user_id' => $user->id,
                'credit_card_id' => $creditCard->id,
                'state' => $state,
            ];

            // Only add address info for non-cart orders
            if ($state !== 'cart') {
                $orderData = array_merge($orderData, [
                    'country' => $countries[array_rand($countries)],
                    'city' => $cities[array_rand($cities)],
                    'street' => $streets[array_rand($streets)],
                    'house_number' => fake()->numberBetween(1, 9999),
                    'zip_code' => fake()->postcode(),
                ]);
            }

            Order::factory()->create($orderData);
        }

        // Create some specific cart orders (incomplete orders)
        foreach (range(1, 10) as $i) {
            $user = $users->random();
            $creditCard = $creditCards->random();

            Order::factory()->create([
                'user_id' => $user->id,
                'credit_card_id' => $creditCard->id,
                'state' => 'cart',
            ]);
        }
    }
}
