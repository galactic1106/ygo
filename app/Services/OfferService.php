<?php
namespace App\Services;

use App\Models\Offer;
use DB;

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
	public function getOfferByCardId($cardId)
	{
		$all=Offer::all();
		$offers=[];
		foreach ($all as $offer) {
			if ($offer->card->id == $cardId) {
				$offers[]=$offer;
			}
		}
		return $offers;
	}
	public function getOfferByCardApiId($apiId)
	{
		$all=Offer::all();
		$offers=[];
		foreach ($all as $offer) {
			if ($offer->card->api_id == $apiId) {
				$offers[]=$offer;
			}
		}
		return $offers;
	}
	public function all()
	{
		return Offer::all();
	}
}