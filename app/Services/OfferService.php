<?php
namespace App\Services;

use App\Models\Offer;

class OfferService
{
	public function get($id)
	{
		return Offer::findOrFail($id);
	}

	public function create(array $data)
	{
		return Offer::create($data);
	}

	public function update(Offer $offer, array $data)
	{
		return $offer->update($data);
	}

	public function delete(Offer $offer)
	{
		return $offer ? $offer->delete() : false;
	}

	public function all()
	{
		return Offer::all();
	}

	public function getOfferByCardId($cardId)
	{
		return Offer::where('card_id', $cardId)->get();
	}

	public function getOfferByCardApiId($apiId)
	{
		return Offer::whereHas('card', function ($query) use ($apiId) {
			$query->where('api_id', $apiId);
		})->get();
	}
}