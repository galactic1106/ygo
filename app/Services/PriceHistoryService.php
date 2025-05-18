<?php

namespace App\Services;
use App\Models\PriceHistory;

class PriceHistoryService
{
	public function getPriceHistoryById($id)
	{
		return PriceHistory::findOrFail($id);
	}

	public function createPriceHistory(array $data)
	{
		return PriceHistory::create($data);
	}

	public function updatePriceHistory(PriceHistory $priceHistory, array $data)
	{
		return $priceHistory->update($data);
	}

	public function deletePriceHistory(PriceHistory $priceHistory)
	{
		return $priceHistory ? $priceHistory->delete() : false;
	}
}