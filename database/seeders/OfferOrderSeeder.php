<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = DB::table('orders')->where('state', '!=', 'cart')->get();
        $offers = DB::table('offers')->get();

        if ($orders->isEmpty() || $offers->isEmpty()) {
            return;
        }

        $offerOrderData = [];

        foreach ($orders as $order) {
            // Each order has 1-5 different offers
            $numberOfOffers = fake()->numberBetween(1, 5);
            $selectedOffers = $offers->random($numberOfOffers);

            foreach ($selectedOffers as $offer) {
                // Quantity ordered is limited by offer quantity
                $maxQuantity = min($offer->quantity, 3);
                $quantity = fake()->numberBetween(1, $maxQuantity);

                $offerOrderData[] = [
                    'order_id' => $order->id,
                    'offer_id' => $offer->id,
                    'quantity' => $quantity,
                ];
            }
        }

        // Add some items to cart orders too
        $cartOrders = DB::table('orders')->where('state', 'cart')->get();
        foreach ($cartOrders as $order) {
            $numberOfOffers = fake()->numberBetween(1, 3);
            $selectedOffers = $offers->random($numberOfOffers);

            foreach ($selectedOffers as $offer) {
                $quantity = fake()->numberBetween(1, min($offer->quantity, 2));

                $offerOrderData[] = [
                    'order_id' => $order->id,
                    'offer_id' => $offer->id,
                    'quantity' => $quantity,
                ];
            }
        }

        DB::table('offer_order')->insertOrIgnore($offerOrderData);
    }
}
