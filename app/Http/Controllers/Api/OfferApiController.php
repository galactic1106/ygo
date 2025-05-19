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
		$offers = $this->offerService->all();
		return response()->json($offers);
	}

	public function find(Offer $offer)
	{
		return response()->json($offer);
	}

	public function findOfferByCardId($cardId)
	{
		$offer = $this->offerService->getOfferByCardId($cardId);
		return response()->json($offer);
	}
	public function getQualities()
	{
		$qualities = $this->offerService->getQualities();
		return response()->json($qualities);
	}
}