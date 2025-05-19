<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CardService;
use App\Models\Card;

class CardApiController extends Controller
{
	protected $cardService;
	public function __construct(CardService $cardService)
	{
		$this->cardService = $cardService;
	}

	public function create(Request $request)
	{
		$param = $request->all();
		$card = $this->cardService->create($param);
		return response()->json($card);
	}

	public function update(Request $request, Card $card)
	{
		$param = $request->all();
		$this->cardService->update($card, $param);
		return response()->json($card->fresh());
	}

	public function delete(Card $card)
	{
		$this->cardService->delete($card);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$cards = $this->cardService->all();
		return response()->json($cards);
	}

	public function find(Card $card)
	{
		return response()->json($card);
	}

}
