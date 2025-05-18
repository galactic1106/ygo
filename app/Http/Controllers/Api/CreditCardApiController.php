<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\CreditCardService;
use Illuminate\Http\Request;
use App\Models\CreditCard;

class CreditCardApiController extends Controller
{
	protected $creditCardService;

	public function __construct(CreditCardService $creditCardService)
	{
		$this->creditCardService = $creditCardService;
	}

	public function create(Request $request)
	{
		$param = $request->all();
		$card = $this->creditCardService->create($param);
		return response()->json($card);
	}

	public function update(Request $request, CreditCard $credit_card)
	{
		$param = $request->all();
		$this->creditCardService->update($credit_card, $param);
		return response()->json($credit_card->fresh());
	}

	public function delete(CreditCard $credit_card)
	{
		$this->creditCardService->delete($credit_card);
		return response()->json(['success' => true]);
	}

	public function all()
	{
		$cards = $this->creditCardService->all();
		return response()->json($cards);
	}

	public function find(CreditCard $credit_card)
	{
		return response()->json($credit_card);
	}
}

