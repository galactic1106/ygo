<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $quality
 * @property string $description
 * @property float $price
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $card_id
 * @property int $user_id
 * @property-read Card $card
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OldPrice> $oldPrices
 * @property-read int|null $old_prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OldQuantity> $oldQuantities
 * @property-read int|null $old_quantities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OfferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Offer whereUserId($value)
 * @mixin \Eloquent
 */
class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;

    protected $fillable = ['quality', 'description', 'price', 'quantity'];

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

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot(['quantity']);
    }
}
