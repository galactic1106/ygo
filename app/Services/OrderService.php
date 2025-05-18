<?php

namespace App\Services;
use App\Models\Order;
class OrderService
{
	public function get($id)
	{
		return Order::findOrFail($id);
	}

	public function create(array $data)
	{
		return Order::create($data);
	}

	public function update(Order $order, array $data)
	{
		return $order->update($data);
	}

	public function delete(Order $order)
	{
		return $order ? $order->delete() : false;
	}
	
	public function all()
	{
		return Order::all();
	}
}