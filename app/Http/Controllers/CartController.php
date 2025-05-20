<?php

namespace App\Http\Controllers;

use App\Services\OfferService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\OrderService;
use App\Services\ItemService;
use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\User;

class CartController extends BaseController
{
	use AuthorizesRequests, ValidatesRequests;
	protected $orderService;
	protected $itemService;
	protected $offerService;
	protected $userService;
	public function __construct(OrderService $orderService, OfferService $offerService, ItemService $itemService, UserService $userService)
	{
		$this->middleware('auth');
		$this->orderService = $orderService;
		$this->offerService = $offerService;
		$this->itemService = $itemService;
		$this->userService = $userService;
	}
	public function index()
	{
		$user = $this->userService->get(auth()->id());
		$cart = $this->orderService->getCart($user);
		$cart->load(['offers.card']);
		return view('cart.index', compact('cart'));
	}

	public function add(Request $request)
	{

		$request->validate([
			'offer_id' => 'required|integer|exists:offers,id',
			'quantity' => 'required|integer|min:1'
		]);
		$offer = $this->offerService->get($request->input('offer_id'));
		$quantity = $request->input('quantity');


		$user = $this->userService->get(auth()->id());

		if ($offer->user_id == $user->id) {
			return back()->with('error', 'you can by your own cards');
		}

		$cart = $this->orderService->getCart($user);

		$ordered = $offer->orders->sum('pivot.quantity');
		$available = $offer->card_quantity - $ordered;
		if ($available - $quantity < 0) {
			return back()->with('error', "You can't add so many to you cart");
		}
		$existingItem = $this->itemService->get($cart, $offer);
		if ($existingItem) {
			// Update the quantity if it already exists
			$this->itemService->update($existingItem, [
				'quantity' => $existingItem->quantity + $quantity
			]);
		} else {
			// Create a new item linking the cart and the offer
			$this->itemService->create([
				'order_id' => $cart->id,
				'offer_id' => $offer->id,
				'quantity' => $quantity
			]);
		}

		return back()->with('success', 'Card added to cart');
	}
}