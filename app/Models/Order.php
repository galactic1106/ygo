<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 
 *
 * @property int $id
 * @property string $state
 * @property string|null $country
 * @property string|null $city
 * @property string|null $street
 * @property int|null $house_number
 * @property string|null $zip_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $credit_card_id
 * @property-read \App\Models\CreditCard|null $creditCard
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereHouseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Order whereZipCode($value)
 * @mixin \Eloquent
 */
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
