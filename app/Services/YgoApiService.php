<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
class YgoApiService
{
	protected $endpoint = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
	protected $cacheMinutes = 60;
	protected $requestsPerSecond = 15; //lasci un margine il limite e 20
	protected $requestNumberKey = 'requests_this_second';
	protected $imageServerEndpoint = 'https://images.ygoprodeck.com/';

	public function getCardData(array $params)
	{
		$queryString = http_build_query($params);
		$cacheKey = 'ygo_card_' . md5($queryString);
		//descrizione remember: se la chiave è presente nella cache prendi i dati altrimenti
		//prendi la default value in questo caso la funzione che fa la richiesta all' api 
		return Cache::remember(
			$cacheKey,
			now()->addMinutes($this->cacheMinutes),
			function () use ($queryString) {
				$success = false;
				$response = null;
				do {
					if (
						Cache::remember($this->requestNumberKey, now()->addSecond(), function () {
							return 0;
						}) > $this->requestsPerSecond
					) {
						usleep(100000);
						continue;
					}
					Cache::increment($this->requestNumberKey);

					$response = Http::get($this->endpoint . '?' . $queryString);
					$success = true;
				} while (!$success);
				return json_encode(json_decode($response->body()), JSON_PRETTY_PRINT);
			}
		);
	}

	public function getImage($url)
	{
		$path = str_replace($this->imageServerEndpoint, '', $url);
		//controlla se l'immagine è già stata scaricata 
		if (!Storage::disk('public')->exists($path)) {
			//scarica l'immagine
			$img = Http::get($url)->body();
			Storage::disk('public')->put($path, $img);
		}
		//restituisci percorso del immagine
		return $path;
	}
}