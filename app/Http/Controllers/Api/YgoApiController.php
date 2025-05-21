<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\YgoApiService;

class YgoApiController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;

	protected $ygoApiService;

	public function __construct(YgoApiService $ygoApiService)
	{
		$this->ygoApiService = $ygoApiService;
	}

	public function makeRequest(Request $request)
	{
		$data = $this->ygoApiService->getCardData($request->all());
		return response()->json($data);
	}
	protected $imageServerEndpoint = 'https://images.ygoprodeck.com/';
	public function getImage(Request $request)
	{
		$url = $request->input('url');
		$path = $this->ygoApiService->getImage($url);
		//restituisci URL dell'immagine
		$fullPath = Storage::disk('public')->path($path);
		return response()->file($fullPath, ['Content-Type' => 'image/jpeg']);
	}

	public function getArchetypes()
	{
		$data = $this->ygoApiService->getArchetypes();
		return response()->json($data);
	}

	public function getAttributes()
	{
		$data = $this->ygoApiService->getAttributes();
		return response()->json($data);
	}

	public function getTypes()
	{
		$data = $this->ygoApiService->getTypes();
		return response()->json($data);
	}

	public function getRaces()
	{
		$data = $this->ygoApiService->getRaces();
		return response()->json($data);
	}
}