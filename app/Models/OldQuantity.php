<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $old_quantity
 * @property string|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $offer_id
 * @property-read \App\Models\Offer $offer
 * @method static \Database\Factories\OldQuantityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereOldQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OldQuantity whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OldQuantity extends Model
{
    /** @use HasFactory<\Database\Factories\OldQuantityFactory> */
    use HasFactory;

    protected $fillable = ['old_quantity'];

    const CREATED_AT = 'change_date';

    /**
     * @return BelongsTo<Offer,OldQuantity>
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
