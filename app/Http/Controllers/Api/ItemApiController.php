<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemApiController extends Controller
{
	protected $itemService;
	public function __construct(ItemService $itemService)
	{
		$this->itemService = $itemService;
	}

	public function create(Request $request)
	{
		$orderId = $request->input('order_id');
		$offerId = $request->input('offer_id');
		$quantity = $request->input('quantity');
		$item = $this->itemService->create([
			'order_id' => $orderId,
			'offer_id' => $offerId,
			'quantity' => $quantity
		]);
		return response()->json($item);
	}

	public function update(Request $request, Item $item)
	{
		$quantity = $request->input('quantity');
		$this->itemService->update($item, [
			'quantity' => $quantity
		]);
		return response()->json($item->fresh());
	}

	public function delete(Item $item)
	{
		$this->itemService->delete($item);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$items = $this->itemService->all();
		return response()->json($items);
	}

	public function find(Item $item)
	{
		return response()->json($item);
	}
}