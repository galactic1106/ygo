<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @mixin IdeHelperCardDeck
 */
class CardDeck extends Pivot
{
    protected $fillable = ["quantity"];
    public $timestamps = true;
}
