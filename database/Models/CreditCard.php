<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CreditCard extends Model
{
    /** @use HasFactory<\Database\Factories\CreditCardFactory> */
    use HasFactory;

    protected $fillable = ["cvv", "number", "expiration"];
    /**
     * @return HasOne<Order,CreditCard>
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
