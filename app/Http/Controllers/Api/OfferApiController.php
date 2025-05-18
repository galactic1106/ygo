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
	public function update(Request $request, $id)
	{
		$param = $request->all();
		$offer = $this->offerService->update($id, $param);
		return response()->json($offer);
	}
	public function delete($id)
	{
		$offer = $this->offerService->delete($id);
		return response()->json($offer);
	}
	public function all()
	{
		$offers = $this->offerService->all();
		return response()->json($offers);
	}
	public function find($id)
	{
		$offer = $this->offerService->get($id);
		return response()->json($offer);
	}
	public function findOfferByCardId($cardId)
	{
		$offer = $this->offerService->getOfferByCardId($cardId);
		return response()->json($offer);
	}
	public function findOfferByCardApiId($apiId)
	{
		$offer = $this->offerService->getOfferByCardApiId($apiId);
		return response()->json($offer);
	}
}