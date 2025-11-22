<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property string $cvv
 * @property string $number
 * @property string $expiration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @method static \Database\Factories\CreditCardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereCvv($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CreditCard whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CreditCard extends Model
{
    /** @use HasFactory<\Database\Factories\CreditCardFactory> */
    use HasFactory;

    protected $fillable = ['cvv', 'number', 'expiration'];

    /**
     * @return HasMany<Order,CreditCard>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
