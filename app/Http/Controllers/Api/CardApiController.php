<?php

namespace App\Http\Controllers;

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
	public function update(Request $request, $id)
	{
		$param = $request->all();
		$card = $this->cardService->update($id, $param);
		return response()->json($card);
	}
	public function delete($id)
	{
		$card = $this->cardService->delete($id);
		return response()->json($card);
	}
	public function All()
	{
		$cards = $this->cardService->All();
		return response()->json($cards);
	}
	public function find($id)
	{
		$card = $this->cardService->get($id);
		return response()->json($card);
	}
	public function findCardByApiId($apiId)
	{
		$card = $this->cardService->getCardByApiId($apiId);
		return response()->json($card);
	}
}
