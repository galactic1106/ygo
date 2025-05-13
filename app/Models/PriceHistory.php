<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    /** @use HasFactory<\Database\Factories\PriceHistoryFactory> */
    use HasFactory;
	protected $table = 'price_history';
	protected $fillable=['old_price'];

	public function offer()
	{
		return $this->belongsTo(Offer::class);
	}
}
