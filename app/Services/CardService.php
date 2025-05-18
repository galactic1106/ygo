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
		return Card::create($data);
	}

	public function update(Card $card, array $data)
	{
		return $card->update($data);
	}

	public function delete(Card $card)
	{
		return $card ? $card->delete() : false;
	}
	public function All()
	{
		return Card::all();
	}

	public function getCardByApiId($apiId)
	{
		return Card::where('api_id', $apiId)->first();
	}
}