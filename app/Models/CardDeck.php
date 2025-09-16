<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property int $id
 * @property string $card_id
 * @property int $deck_id
 * @property int $quantity
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereDeckId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CardDeck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CardDeck extends Pivot
{
    protected $fillable = ["quantity"];
    public $timestamps = false;
}
