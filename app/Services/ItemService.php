<?php

namespace App\Services;
use App\Models\Item;
use App\Models\Offer;
use App\Models\Order;

class ItemService
{
	public function get(Order $order,Offer $offer)
	{
		return Item::where('order_id','=',$order->id)->where('offer_id','=',$offer->id)->first();
	}

	public function create(array $data)
	{
		return Item::create($data);
	}

	public function update(Item $item, array $data)
	{
		return $item->update($data);
	}

	public function delete(Item $item)
	{
		return $item ? $item->delete() : false;
	}

	public function all()
	{
		return Item::all();
	}
}