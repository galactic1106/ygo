<?php
namespace App\Services;
use App\Models\Deck;

class DeckService
{
	public function get($id)
	{
		return Deck::findOrFail($id);
	}

	public function create(array $data)
	{
		return Deck::create($data);
	}

	public function update(Deck $deck, array $data)
	{
		return $deck->update($data);
	}

	public function delete(Deck $deck)
	{
		return $deck ? $deck->delete() : false;
	}
	public function all()
	{
		return Deck::all();
	}
}