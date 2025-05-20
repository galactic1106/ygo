<?php
namespace App\Services;
use App\Models\Deck;
use App\Models\User;

class DeckService
{
	public function get($id)
	{
		return Deck::with('cards')->findOrFail($id);
	}

	public function getUserDecks(User $user)
	{
		return Deck::where('user_id', $user->id)->with('cards')->get();
	}
	public function create(array $data)
	{
		return Deck::create($data);
	}

	public function update(Deck $deck, array $data)
	{
		return $deck->update($data);
	}

	public function delete(Deck $deck)
	{
		$deck->cards()->detach(); // Detach all cards (delete all pivot rows)
		return $deck ? $deck->delete() : false;
	}

	public function all()
	{
		return Deck::all();
	}

	public function addCard(Deck $deck, $cardId, $quantity = 1)
	{
		$current = $deck->cards()->where('card_id', $cardId)->first();
		if ($current) {
			$newQty = min($current->pivot->quantity + $quantity, 3);
			$deck->cards()->updateExistingPivot($cardId, [
				'quantity' => $newQty
			]);
		} else {
			$deck->cards()->attach($cardId, ['quantity' => min($quantity, 3)]);
		}
		return $deck->fresh('cards');
	}

	public function removeCard(Deck $deck, $cardId, $quantity = 1)
	{
		$current = $deck->cards()->where('card_id', $cardId)->first();
		if ($current) {
			$newQty = $current->pivot->quantity - $quantity;
			if ($newQty > 0) {
				$deck->cards()->updateExistingPivot($cardId, ['quantity' => $newQty]);
			} else {
				$deck->cards()->detach($cardId);
			}
		}
		return $deck->fresh('cards');
	}
}