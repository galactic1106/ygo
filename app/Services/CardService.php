<?php
namespace App\Services;
use App\Models\Card;

class CardService
{
	public function getCardById($id)
	{
		return Card::findOrFail($id);
	}

	public function createCard(array $data)
	{
		return Card::create($data);
	}

	public function updateCard(Card $card, array $data)
	{
		return $card->update($data);
	}

	public function deleteCard(Card $card)
	{
		return $card ? $card->delete() : false;
	}
}