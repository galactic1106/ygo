<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        "state",
        "country",
        "city",
        "street",
        "house_number",
        "zip_code",
    ];

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class)->withPivot("quantity");
    }

    /**
     * @return BelongsTo<User,Order>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * @return BelongsTo<CreditCard,Order>
     */
    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }
}
