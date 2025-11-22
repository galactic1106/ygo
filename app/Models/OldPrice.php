<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property float $old_price
 * @property string|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $offer_id
 * @property-read \App\Models\Offer $offer
 * @method static \Database\Factories\OldPriceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OldPrice extends Model
{
    /** @use HasFactory<\Database\Factories\OldPriceFactory> */
    use HasFactory;

    protected $fillable = ['old_price'];

    const CREATED_AT = 'change_date';

    /**
     * @return BelongsTo<Offer,OldPrice>
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
