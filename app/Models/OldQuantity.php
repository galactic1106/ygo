<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperOldQuantity
 */
class OldQuantity extends Model
{
    /** @use HasFactory<\Database\Factories\OldQuantityFactory> */
    use HasFactory;

    protected $fillable = ["old_quantity"];

    const CREATED_AT = "change_date";
    /**
     * @return BelongsTo<Offer,OldQuantity>
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }
}
