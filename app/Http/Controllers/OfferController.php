<?php

namespace App\Http\Controllers;

use App\Services\OfferService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CardService;

class OfferController extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	protected $offerService;
	protected $cardService;
	public function __construct(OfferService $offerService, CardService $cardService)
	{
		$this->middleware('auth');
		$this->offerService = $offerService;
		$this->cardService = $cardService;
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
		$this->cardService->create(['id'=>$validated['card_id']]);
		$this->offerService->create($validated);

		return redirect()->back()->with('success', 'Offer created successfully!');
	}
}
