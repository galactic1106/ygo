<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Cache;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Storage;

class YgoApiController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;
	protected $cardInfoEndPoint = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
	protected function makeRequest(Request $params)
	{
		$queryString = http_build_query($params->all());
		if (!Cache::has($queryString)) {

			// Keep trying until the request is successful
			$success = false;

			while (!$success) {

				RateLimiter::attempt(
					'api requests',
					$perMinute = 15,
					function () use ($queryString) {
						//manda la richiesta all api
						$apiResponce = Http::get($this->cardInfoEndPoint . '?' . $queryString);
						//inserisci la risposta nella cache per 2 ore
						Cache::put($queryString, $apiResponce->body(), now()->addMinute(120));

						/*
										  //
										  $card_number = $apiResponce->json()['id'];
										  $in_db = DB::table('cards')->where('api_id', 'like', $card_number)->count();
										  if ($in_db == 0) {
											  Card::create(['api_id' => $card_number]);
										  }
										  */

						return true;
					}
				);

				if (!$success) {
					usleep(500000); // Sleep for 500ms (0.5 seconds)
				}
			}
		}

		return Cache::get($queryString);
	}

	protected $imageServerEndpoint = 'https://images.ygoprodeck.com/';
	public function getImage(Request $request)
	{

		$url = $request->input('url');
		$path = str_replace($this->imageServerEndpoint, '', $url);
		//controlla se l'immagine è già stata scaricata 
		if (!Storage::disk('public')->exist($path)) {
			//scarica l'immagine
			$img=Http::get($url)->body();
			Storage::disk('public')->put($path,$img);
		}
		//restituisci URL dell'immagine
		return asset($path);
	}
}