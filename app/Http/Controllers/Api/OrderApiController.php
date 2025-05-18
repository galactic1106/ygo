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
	public function update(Request $request, $id)
	{
		$param = $request->all();
		$order = $this->orderService->update($id, $param);
		return response()->json($order);
	}
	public function delete($id)
	{
		$order = $this->orderService->delete($id);
		return response()->json($order);
	}
	public function all()
	{
		$orders = $this->orderService->all();
		return response()->json($orders);
	}
	public function find($id)
	{
		$order = $this->orderService->get($id);
		return response()->json($order);
	}
}