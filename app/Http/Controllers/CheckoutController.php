<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\ItemService;
use Illuminate\Support\Facades\DB;
use App\Models\CreditCard;
use Exception;

class CheckoutController extends Controller
{
	protected $orderService;
	protected $itemService;

	public function __construct(OrderService $orderService, ItemService $itemService)
	{
		$this->middleware('auth');
		$this->orderService = $orderService;
		$this->itemService = $itemService;
	}

	public function show(Request $request)
	{
		$user = auth()->user();
		$cart = $this->orderService->getCart($user);
		if (!$cart) {
			return redirect()->route('cart.index')->with('error', 'No cart found.');
		}
		$cart->load(['offers.card']);
		return view('checkout.show', compact('cart'));
	}

	public function process(Request $request)
	{
		$user = auth()->user();
		$cart = $this->orderService->getCart($user);
		if (!$cart) {
			return redirect()->route('cart.index')->with('error', 'No cart found.');
		}

		$request->validate([
			'country' => 'required|string|max:64',
			'city' => 'required|string|max:64',
			'street' => 'required|string|max:128',
			'house_number' => 'required|string|max:16',
			'zip_code' => 'required|string|max:16',
			'card_number' => 'required|string',
			'card_expiration' => 'required|string',
			'cvv' => 'required|string',
		]);

		DB::beginTransaction();
		try {
			// Save credit card info (for record, not linked to user)
			$creditCard = CreditCard::create([
				'card_number' => explode(' ', $request->input('card_number'))[3],
				'expiration_date' => $request->input('card_expiration'),
				'cvv' => $request->input('cvv'),
			]);

			// Mark order as completed and link credit card and shipping info
			$this->orderService->update($cart, [
				'state' => 'paid',
				'order_date' => now(),
				'credit_card_id' => $creditCard->id,
				'country' => $request->input('country'),
				'city' => $request->input('city'),
				'street' => $request->input('street'),
				'house_number' => $request->input('house_number'),
				'zip_code' => $request->input('zip_code'),
			]);

			// Create a new cart for the user
			$this->orderService->create([
				'user_id' => $user->id,
				'state' => 'cart',
			]);

			DB::commit();
			return redirect()->route('account.index')->with('success', 'Checkout completed successfully!');
		} catch (Exception $e) {
			DB::rollBack();
			return redirect()->route('checkout.show')->with('error', 'Checkout failed: ' . $e->getMessage());
		}
	}
}