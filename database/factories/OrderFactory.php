<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\CreditCard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'credit_card_id' => CreditCard::factory(),
            'state' => fake()->randomElement(['cart', 'processing', 'paid']),
            'country' => fake()->optional()->country(),
            'city' => fake()->optional()->city(),
            'street' => fake()->optional()->streetName(),
            'house_number' => fake()->optional()->numberBetween(1, 9999),
            'zip_code' => fake()->optional()->postcode(),
        ];
    }
}
