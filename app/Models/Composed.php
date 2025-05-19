<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Composed extends Pivot
{
    protected $table='composed';
	protected $fillable=['quantity', 'deck_id', 'card_id'];
}
