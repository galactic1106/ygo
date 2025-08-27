<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Deck extends Model
{
    /** @use HasFactory<\Database\Factories\DeckFactory> */
    use HasFactory;

    protected $fillable = ['name', 'notes'];
    public $timestamps = true;
    /**
     * @return BelongsTo<User,Deck>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)->withPivot('quantity');
    }
}
