<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperOldPrice
 */
class OldPrice extends Model
{
    /** @use HasFactory<\Database\Factories\OldPriceFactory> */
    use HasFactory;

    protected $fillable = ["old_price"];

    const CREATED_AT = "change_date";
    /**
     * @return BelongsTo<Offer,OldPrice>
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
