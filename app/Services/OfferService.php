<?php
namespace App\Services;

use App\Models\Offer;

class OfferService
{
	public function getOfferById($id)
	{
		return Offer::findOrFail($id);
	}
	public function createOffer(array $data)
	{
		return Offer::create($data);
	}
	public function updateOffer(Offer $offer, array $data)
	{
		return $offer->update($data);
	}
	public function deleteOffer(Offer $offer)
	{
		return $offer ? $offer->delete() : false;
	}
	public function getOfferByCardId($cardId)
	{
		return Offer::where('card_id', $cardId)->first();
	}
}