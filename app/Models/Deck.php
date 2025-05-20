<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Deck extends Model
{
	/** @use HasFactory<\Database\Factories\DeckFactory> */
	use HasFactory;


	protected $table = 'decks';
	protected $fillable = ['name', 'notes', 'user_id', 'id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function cards()
	{
		return $this->belongsToMany(Card::class, 'composed')->withPivot('quantity')->using(Composed::class);
	}
}
