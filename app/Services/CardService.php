<?php
namespace App\Services;
use App\Models\Card;

class CardService
{
	public function get($id)
	{
		return Card::findOrFail($id);
	}

	public function create(array $data)
	{
		return Card::createOrFirst($data);
	}

	public function update(Card $card, array $data)
	{
		return $card->update($data);
	}

	public function delete(Card $card)
	{
		return $card ? $card->delete() : false;
	}

	public function all()
	{
		return Card::all();
	}
}