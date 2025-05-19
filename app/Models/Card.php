<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
	/** @use HasFactory<\Database\Factories\CardFactory> */
	use HasFactory;

	protected $table = 'cards';
	protected $fillable = ['id'];
	public $timestamps = false;
	public function offers()
	{
		return $this->hasMany(Offer::class);
	}
	public function decks()
	{

		return $this->belongsToMany(Deck::class)->withPivot('quantity');
	}
}
