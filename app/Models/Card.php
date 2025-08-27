<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
