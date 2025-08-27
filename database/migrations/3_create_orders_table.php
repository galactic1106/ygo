<?php

use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("orders", function (Blueprint $table) {
            $table->id();
            $table->enum("state", ["cart", "processing", "paid"]);
            $table->string("country")->nullable();
            $table->string("city")->nullable();
            $table->string("street")->nullable();
            $table->smallInteger("house_number")->nullable();
            $table->string("zip_code")->nullable();
            $table->timestamps();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(CreditCard::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("orders");
    }
};
