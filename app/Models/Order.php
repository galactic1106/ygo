<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use App\Models\Item;
class Order extends Model
{
	/** @use HasFactory<\Database\Factories\OrderFactory> */
	use HasFactory;
	protected $table = 'orders';
	protected $fillable = [
		'state',
		'order_date',
		'country',
		'city',
		'street',
		'house_number',
		'zip_code',
		'user_id',
		'credit_card_id',
		'id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function offers()
	{
		return $this->belongsToMany(Offer::class, 'items')
			->withPivot('quantity')
			->using(Item::class);
	}

	public function creditCard()
	{
		return $this->belongsTo(CreditCard::class);
	}
}
