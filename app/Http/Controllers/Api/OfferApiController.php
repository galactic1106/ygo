<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\OfferService;
use Illuminate\Http\Request;
use App\Models\Offer;

class OfferApiController extends Controller
{
	protected $offerService;

	public function __construct(OfferService $offerService)
	{
		$this->offerService = $offerService;
	}

	public function create(Request $request)
	{
		$param = $request->all();
		$offer = $this->offerService->create($param);
		return response()->json($offer);
	}

	public function update(Request $request, Offer $offer)
	{
		$param = $request->all();
		$this->offerService->update($offer, $param);
		return response()->json($offer->fresh());
	}

	public function delete(Offer $offer)
	{
		$this->offerService->delete($offer);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$offers = $this->offerService->all()->load('user:id,name');
		return response()->json($offers);
	}

	public function find($id, $cardId)
	{
		if ($cardId) {
			return $this->findOfferByCardId($cardId);
		}
		if (!$id) {
			return response()->json(['error' => 'ID not provided']);
		}
		$offer = $this->offerService->get($id);
		if ($offer) {
			$offer->load('user:id,name');
			return response()->json($offer);
		}
		return response()->json(['error' => 'Offer not found']);
	}

	public function findOfferByCardId($cardId)
	{
		$offers = $this->offerService->getOfferByCardId($cardId);
		if ($offers) {
			$offers->load(['user:id,name', 'orders']);
			$offers = $offers->map(function ($offer) {
				return [
					'id' => $offer->id,
					'user' => $offer->user,
					'price' => $offer->price,
					'card_quantity' => $offer->card_quantity,
					'available_quantity' => $offer->available_quantity
				];
			});
			return response()->json($offers);
		}
		return response()->json(['error' => 'Offer(s) not found'], 404);
	}
	public function getQualities()
	{
		$qualities = $this->offerService->getQualities();
		return response()->json($qualities);
	}
}