<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditCard extends Model
{
    /** @use HasFactory<\Database\Factories\CreditCardFactory> */
    use HasFactory;

    protected $fillable = ['cvv', 'number', 'expiration'];
    
    /**
     * @return HasMany<Order,CreditCard>
     */
    public function orders():HasMany
    {
        return $this->hasMany(Order::class);
    }
}
