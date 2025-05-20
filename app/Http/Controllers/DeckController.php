<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Services\DeckService;
use Illuminate\Http\Request;
use App\Services\CardService;
use App\Services\YgoApiService;
class DeckController extends Controller
{
	protected $deckService;
	protected $cardService;
	protected $ygoApiService;
	public function __construct(DeckService $deckService, CardService $cardService, YgoApiService $ygoApiService)
	{
		$this->middleware('auth');
		$this->deckService = $deckService;
		$this->cardService = $cardService;
		$this->ygoApiService = $ygoApiService;
	}

	public function index()
	{
		// Show all decks for the authenticated user
		$user = auth()->user();
		$decks = $this->deckService->getUserDecks($user);
		return view('decks.index', compact('decks'));
	}

	public function show($id)
	{
		$deck = $this->deckService->get($id);

		//check if the authenticated user owns this deck
		if (auth()->id() !== $deck->user_id) {
			abort(403, 'Unauthorized');
		}
		$cards=[];
		foreach($deck->cards as $card)
		{
			$cards[]=$card->id;
		}
		$cards=$this->ygoApiService->getCardData(['id'=>implode(',',$cards)])['data'];
		//return $cards;
		return view('decks.show', compact('deck','cards'));
	}

	public function create(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:64',
			'notes' => 'nullable|string|max:255',
		]);

		$user = auth()->user();
		$deck = $this->deckService->create([
			'name' => $request->input('name'),
			'notes' => $request->input('notes'),
			'user_id' => $user->id,
		]);

		return redirect()->route('decks.index')->with('success', 'Deck created successfully!');
	}

	public function delete($id)
	{
		$deck = $this->deckService->get($id);

		// Check if the authenticated user owns this deck
		if (auth()->id() !== $deck->user_id) {
			abort(403, 'Unauthorized');
		}

		$this->deckService->delete($deck);

		return redirect()->route('decks.index')->with('success', 'Deck deleted successfully!');
	}

	public function addCard(Request $request)
	{
		$request->validate([
			'deck_id' => 'required|integer	',
			'card_id' => 'required|integer',
			'quantity' => 'nullable|integer|min:1|max:3',
		]);

		$deck = $this->deckService->get($request->input('deck_id'));
		$this->cardService->create(['id'=>$request->input('card_id')]);
		// Check if the authenticated user owns this deck
		if (auth()->id() !== $deck->user_id) {
			abort(403, 'Unauthorized');
		}

		$cardId = $request->input('card_id');
		$quantity = $request->input('quantity', 1);

		$card = $this->cardService->get($cardId);
		if (!$card) {
			$apiData = $this->ygoApiService->getCardData(['id' => $cardId]);
			if (!empty($apiData['data'][0])) {
				$card = $this->cardService->create($apiData['data'][0]);
			} else {
				return redirect()->back()->with('error', 'Card not found in database or API.');
			}
		}

		$this->deckService->addCard($deck, $cardId, $quantity);

		return redirect()->back()->with('success', 'Card added to deck!');
	}

	public function removeCard(Request $request)
	{
		$request->validate([
			'deck_id' => 'required|integer|exists:decks,id',
			'card_id' => 'required|integer|exists:cards,id',
			'quantity' => 'nullable|integer|min:1|max:3',
		]);

		$deck = $this->deckService->get($request->input('deck_id'));

		// Check if the authenticated user owns this deck
		if (auth()->id() !== $deck->user_id) {
			abort(403, 'Unauthorized');
		}

		$quantity = $request->input('quantity', 1);
		$this->deckService->removeCard($deck, $request->input('card_id'), $quantity);

		return redirect()->back()->with('success', 'Card removed from deck!');
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required|string|max:64',
			'notes' => 'nullable|string|max:255',
		]);

		$deck = $this->deckService->get($id);

		// Check if the authenticated user owns this deck
		if (auth()->id() !== $deck->user_id) {
			abort(403, 'Unauthorized');
		}

		$this->deckService->update($deck, [
			'name' => $request->input('name'),
			'notes' => $request->input('notes'),
		]);

		return redirect()->route('decks.show', $id)->with('success', 'Deck updated successfully!');
	}
}