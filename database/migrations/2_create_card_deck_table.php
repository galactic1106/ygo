<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Deck;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("card_deck", function (Blueprint $table) {
            $table->id();
            $table->string("card_id", 8);
            $table
                ->foreign("card_id")
                ->references("id")
                ->on("cards")
                ->onDelete("cascade");
            $table
                ->foreignIdFor(Deck::class)
                ->constrained()
                ->onDelete("cascade");
            $table->smallInteger("quantity")->unsigned()->default(1);
            $table->timestamps();

            // Ensure each card can only exist once per deck
            $table->unique(["card_id", "deck_id"]);

            // Add index for better query performance
            $table->index(["deck_id", "card_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("card_deck");
    }
};
