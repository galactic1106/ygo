<?php

namespace App\Http\Controllers;

use App\Services\OfferService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CardService;
use App\Models\Offer;
use App\Services\PriceHistoryService;

class OfferController extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	protected $offerService;
	protected $cardService;
	protected $priceHistoryService;

	public function __construct(OfferService $offerService, CardService $cardService, PriceHistoryService $priceHistoryService)
	{
		$this->middleware('auth');
		$this->offerService = $offerService;
		$this->cardService = $cardService;
		$this->priceHistoryService = $priceHistoryService;
	}

	public function makeOffer(Request $request)
	{
		$validated = $request->validate([
			'card_id' => 'required|integer',
			'image_number' => 'required|integer',
			'quality' => 'required|string',
			'card_quantity' => 'required|integer|min:1',
			'price' => 'required|numeric|min:1',
			'description' => 'nullable|string|max:1000',
		]);
		$validated['user_id'] = auth()->id();
		$this->cardService->create(['id' => $validated['card_id']]);
		$this->offerService->create($validated);

		return redirect()->back()->with('success', 'Offer created successfully!');
	}

	public function changePrice(Request $request, $offerId)
	{
		$validated = $request->validate([
			'	' => 'required|numeric|min:1',
		]);

		$offer = Offer::findOrFail($offerId);

		// Only allow the owner to change the price
		if ($offer->user_id !== auth()->id()) {
			abort(403, 'Unauthorized');
		}

		// Save old price to price_history
		$this->priceHistoryService->create([
			'old_price' => $offer->price,
			'offer_id' => $offer->id,
			'created_at' => now(),
		]);

		// Update the offer price
		$offer->price = $validated['price'];
		$offer->save();

		return redirect()->back()->with('success', 'Offer price updated and history recorded.');
	}
}
