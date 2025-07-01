<?php

use App\Models\Offer;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("offer_order", function (Blueprint $table) {
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(Offer::class)->constrained();
            $table->smallInteger("quantity")->unsigned()->default(1);
            $table->primary(["offer_id", "order_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("offer_order");
    }
};
