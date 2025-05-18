<?php 
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
	protected $itemService;
	public function __construct(ItemService $itemService)
	{
		$this->itemService = $itemService;
	}
	public function create(Request $request)
	{
		$orderId= $request->input('order_id');
		$offerId= $request->input('offer_id');
		$quantity= $request->input('quantity');
		$this->itemService->create([
			'order_id' => $orderId,
			'offer_id' => $offerId,
			'quantity' => $quantity
		]);
	}
	public function update(Request $request, $id)
	{
		$quantity = $request->input('quantity');
		$this->itemService->update($id, [
			'quantity' => $quantity
		]);
	}
	public function delete($id)
	{
		$this->itemService->delete($id);
	}

	public function all()
	{
		$items = $this->itemService->all();
		return response()->json($items);
	}

	public function find($id)
	{
		$item = $this->itemService->get($id);
		return response()->json($item);
	}
}