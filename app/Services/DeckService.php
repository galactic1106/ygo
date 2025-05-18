<?php
namespace App\Services;
use App\Models\Deck;

class DeckService
{
	public function getDeckById($id)
	{
		return Deck::findOrFail($id);
	}

	public function createDeck(array $data)
	{
		return Deck::create($data);
	}

	public function updateDeck(Deck $deck, array $data)
	{
		return $deck->update($data);
	}

	public function deleteDeck(Deck $deck)
	{
		return $deck ? $deck->delete() : false;
	}
}