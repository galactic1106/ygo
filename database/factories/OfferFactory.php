<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
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
            'card_id' => Card::factory(),
            'quality' => fake()->randomElement(['Mint', 'Near Mint', 'Excellent', 'Good', 'Light Played', 'Played', 'Poor']),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0.5, 100.0),
            'quantity' => fake()->numberBetween(1, 3),
        ];
    }
}
