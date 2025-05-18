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

	public function update(Request $request, Deck $deck)
	{
		$param = $request->all();
		$this->deckService->update($deck, $param);
		return response()->json($deck->fresh());
	}

	public function delete(Deck $deck)
	{
		$this->deckService->delete($deck);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$decks = $this->deckService->all();
		return response()->json($decks);
	}

	public function find(Deck $deck)
	{
		return response()->json($deck);
	}
}
