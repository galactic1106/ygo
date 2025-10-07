<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string|null $notes
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Card> $cards
 * @property-read int|null $cards_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\DeckFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deck whereUserId($value)
 *
 * @mixin \Eloquent
 */
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

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class)->withPivot('quantity');
    }
}
