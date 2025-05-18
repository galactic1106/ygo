<?php

namespace App\Services;
use App\Models\Order;
class OrderService
{
	public function getOrderById($id)
	{
		return Order::findOrFail($id);
	}

	public function createOrder(array $data)
	{
		return Order::create($data);
	}

	public function updateOrder(Order $order, array $data)
	{
		return $order->update($data);
	}

	public function deleteOrder(Order $order)
	{
		return $order ? $order->delete() : false;
	}
}	