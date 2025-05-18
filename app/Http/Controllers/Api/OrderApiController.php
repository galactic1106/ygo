<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderApiController extends Controller
{
	protected $orderService;

	public function __construct(OrderService $orderService)
	{
		$this->orderService = $orderService;
	}

	public function create(Request $request)
	{
		$param = $request->all();
		$order = $this->orderService->create($param);
		return response()->json($order);
	}

	public function update(Request $request, Order $order)
	{
		$param = $request->all();
		$this->orderService->update($order, $param);
		return response()->json($order->fresh());
	}

	public function delete(Order $order)
	{
		$this->orderService->delete($order);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$orders = $this->orderService->all();
		return response()->json($orders);
	}

	public function find(Order $order)
	{
		return response()->json($order);
	}
}