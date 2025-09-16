<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property string $id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deck> $decks
 * @property-read int|null $decks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Offer> $offers
 * @property-read int|null $offers_count
 * @method static \Database\Factories\CardFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Card whereId($value)
 * @mixin \Eloquent
 */
class Card extends Model
{
    /** @use HasFactory<\Database\Factories\CardFactory> */
    use HasFactory;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = "string";

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["id"];
    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function decks(): BelongsToMany
    {
        return $this->belongsToMany(Deck::class)->withPivot("quantity");
    }

    /**
     * @return HasMany<Offer,Card>
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}
