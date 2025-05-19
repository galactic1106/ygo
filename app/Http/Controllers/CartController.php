<?php

namespace App\Http\Controllers;

use App\Services\OfferService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\OrderService;
use App\Services\ItemService;
use App\Models\Offer;

class CartController extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	protected $orderService;
	protected $itemService;
	protected $offerService;
	public function __construct(OrderService $orderService, OfferService $offerService, ItemService $itemService)
	{
		$this->middleware('auth');
		$this->orderService = $orderService;
		$this->offerService = $offerService;
		$this->itemService = $itemService;
	}
	public function index()
	{
		$cart = auth()->user()->orders()->where('state', '=', 'cart')->first();
		return view('cart.index', compact('cart'));
	}
	
	public function add(Offer $offer, $quantity)
	{
		$cart = auth()->user()->orders()->where('state', '=', 'cart')->first();

		$item = $this->itemService->get($cart, $offer);

		if ($item == null) {
			$item = $this->itemService->create(['order_id' => $cart->id, 'offer_id' => $offer->id, 'quantity' => 0]);
		}

		$this->itemService->update($item, ['quantity' => $quantity + $item->quantity]);

		return redirect()->route('cart.index')->with('success', 'Card added to cart');
	}
}