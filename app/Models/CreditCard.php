<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    /** @use HasFactory<\Database\Factories\CreditCardFactory> */
    use HasFactory;
    protected $table = 'credit_cards';
    protected $fillable = [
        'card_number',
        'expiration_date',
        'cvv'
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
