<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\CreditCardService;
use Illuminate\Http\Request;

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
	public function update(Request $request, $id)
	{
		$param = $request->all();
		$card = $this->creditCardService->update($id, $param);
		return response()->json($card);
	}
	public function delete($id)
	{
		$card = $this->creditCardService->delete($id);
		return response()->json($card);
	}
	public function all()
	{
		$cards = $this->creditCardService->all();
		return response()->json($cards);
	}
	public function find($id)
	{
		$card = $this->creditCardService->get($id);
		return response()->json($card);	
	}
}

	