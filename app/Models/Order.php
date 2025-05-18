<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
		'zip_code'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function offers()
	{
		return $this->belongsToMany(Offer::class)->withPivot('quantity');
	}

	public function creditCard()
	{
		return $this->belongsTo(CreditCard::class);
	}
}
