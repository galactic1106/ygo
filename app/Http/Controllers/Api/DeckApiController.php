<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\DeckService;
use Illuminate\Http\Request;
use App\Models\Deck;

class DeckApiController extends Controller
{
	protected $deckService;

	public function __construct(DeckService $deckService)
	{
		$this->deckService = $deckService;
	}

	public function create(Request $request)
	{
		$param = $request->all();
		$deck = $this->deckService->create($param);
		return response()->json($deck);
	}
	public function update(Request $request, $id)
	{
		$param = $request->all();
		$deck = $this->deckService->update($id, $param);
		return response()->json($deck);
	}
	public function delete($id)
	{
		$deck = $this->deckService->delete($id);
		return response()->json($deck);
	}
	public function all()
	{
		$decks = $this->deckService->all();
		return response()->json($decks);
	}
	public function find($id)
	{
		$deck = $this->deckService->get($id);
		return response()->json($deck);
	}
}
	