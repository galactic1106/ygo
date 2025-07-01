<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;

    protected $fillable = ["quality", "description", "price", "quantity"];
    /**
     * @return BelongsTo<User,Offer>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Card,Offer>
     */
    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
    /**
     * @return HasMany<OldQuantity,Offer>
     */
    public function oldQuantities(): HasMany
    {
        return $this->hasMany(OldQuantity::class);
    }
    /**
     * @return HasMany<OldPrice,Offer>
     */
    public function oldPrices(): HasMany
    {
        return $this->hasMany(OldPrice::class);
    }
}
