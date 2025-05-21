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
		return $offer->delete();
	}

	public function all()
	{
		return Offer::all();
	}

	public function getOfferByCardId($cardId)
	{
		// $cardId is the API id, stored in cards.id and offers.card_id
		return Offer::where('card_id', $cardId)->get();
	}

	public function getQualities()
	{
		return ['mint', 'near mint', 'excellent', 'good', 'light played', 'played', 'poor'];
	}
}