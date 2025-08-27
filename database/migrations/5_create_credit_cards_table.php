<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("credit_cards", function (Blueprint $table) {
            $table->id();
            $table->string("cvv", 3);
            $table->string("number", 4);
            $table->date("expiration");
            $table->timestamps();
            
            $table->unique(['cvv','number','expiration']);
            $table->index(['cvv','number','expiration']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("credit_cards");
    }
};
