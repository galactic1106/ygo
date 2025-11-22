<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @mixin IdeHelperOfferOrder
 * @property int $order_id
 * @property int $offer_id
 * @property int $quantity
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OfferOrder whereQuantity($value)
 * @mixin \Eloquent
 */
class OfferOrder extends Pivot
{
    protected $fillable = ['quantity'];

    public $timestamps = false;
}
