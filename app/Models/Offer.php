<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Item;
class Offer extends Model
{
	/** @use HasFactory<\Database\Factories\OfferFactory> */
	use HasFactory;

	protected $table = 'offers';
	protected $fillable = [
		'id',
		'card_quantity',
		'image_number',
		'quality',
		'price',
		'description',
		'card_id',
		'user_id'
	];

	protected $appends = ['available_quantity'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	public function card()
	{
		return $this->belongsTo(Card::class);
	}
	public function prices()
	{
		return $this->hasMany(PriceHistory::class);
	}

	public function getAvailableQuantityAttribute()
	{
		$ordered = $this->orders->sum(function ($order) {
			return $order->pivot->quantity;
		});
		return $this->card_quantity - $ordered;
	}
	public function orders()
	{
		return $this->belongsToMany(Order::class, 'items')
			->withPivot('quantity')
			->using(Item::class);
	}
}
