<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;
use function PHPUnit\Framework\returnArgument;


class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;

	protected $table='offers';
	protected $fillable=[
		'card_quantity',
		'state',
		'price',
		'description'
	];

	public function user(){
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

	public function orders()
	{
		return $this->belongsToMany(Order::class)->withPivot('quantity');
	}
}
