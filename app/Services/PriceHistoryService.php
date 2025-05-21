<?php

namespace App\Services;
use App\Models\PriceHistory;

class PriceHistoryService
{
	public function get($id)
	{
		return PriceHistory::findOrFail($id);
	}

	public function create(array $data)
	{
		return PriceHistory::create($data);
	}

	public function update(PriceHistory $priceHistory, array $data)
	{
		return $priceHistory->update($data);
	}

	public function delete(PriceHistory $priceHistory)
	{
		return $priceHistory->delete();
	}

	public function all()
	{
		return PriceHistory::all();
	}

}