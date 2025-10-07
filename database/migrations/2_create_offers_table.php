<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->enum('quality', [
                'Mint',
                'Near Mint',
                'Excellent',
                'Good',
                'Light Played',
                'Played',
                'Poor',
            ]);
            $table->string('description', 300);
            $table->float('price');
            $table->smallInteger('quantity');
            $table->timestamps();
            $table->string('card_id', 8);
            $table
                ->foreign('card_id')
                ->references('id')
                ->on('cards')
                ->onDelete('cascade');
            $table->foreignIdFor(User::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
