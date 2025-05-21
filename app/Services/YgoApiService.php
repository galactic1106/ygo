<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Log;

class YgoApiService
{
	protected $endpoint = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
	protected $imageServerEndpoint = 'https://images.ygoprodeck.com/';
	protected $cacheMinutes = 60;
	protected $requestsPerSecond = 15; //actuall limit = 20
	protected $requestNumberKey = 'requests_this_second';
	
	//private helper for rate limiting
	private function rateLimit()
	{
		while (
			Cache::remember($this->requestNumberKey, now()->addSecond(), function () {
				return 0;
			}) > $this->requestsPerSecond
		) {
			usleep(100000);
		}
		Cache::increment($this->requestNumberKey);
	}

	public function getCardData(array $params)
	{

		$queryString = http_build_query($params);
		$cacheKey = 'ygo_card_' . md5($queryString);

		return Cache::remember(
			$cacheKey,
			now()->addMinutes($this->cacheMinutes),
			function () use ($queryString, $params) {
				Log::info('YgoApiService:getCardData request', [
					'endpoint' => $this->endpoint,
					'params' => $params,
					'full_url' => $this->endpoint . '?' . $queryString,
				]);
				$response = null;
				$start = microtime(true);
				do {
					$this->rateLimit();
					try {
						$response = Http::timeout(10)->get($this->endpoint . '?' . $queryString);
					} catch (\Exception $e) {
						Log::error('YgoApiService:getCardData error', [
							'exception' => $e->getMessage(),
							'params' => $params,
						]);
						return ['data' => []];
					}
					// Stop retrying if more than 10 seconds have passed
					if ((microtime(true) - $start) > 10) {
						Log::warning('YgoApiService:getCardData timeout', [
							'params' => $params,
						]);
						return ['data' => []];
					}
				} while (!$response->successful());
				$data = $response->json();
				return $data;
			}
		);
	}
	public function getImage($url)
	{
		$path = str_replace($this->imageServerEndpoint, '', $url);

		// Check if the image is already downloaded
		if (!Storage::disk('public')->exists($path)) {
			// Download the image
			$img = Http::get($url)->body();
			Storage::disk('public')->put($path, $img);
		}
		// Return the image path
		return $path;
	}

	public function getArchetypes()
	{
		$cacheKey = 'ygo_archetypes';
		return Cache::remember($cacheKey, now()->addHours(12), function () {
			$url = 'https://db.ygoprodeck.com/api/v7/archetypes.php';
			$this->rateLimit();
			$response = Http::get($url);
			return $response->json();
		});
	}

	public function getAttributes()
	{
		// Hardcoded list from YGOPRODeck docs
		return [
			'DARK',
			'DIVINE',
			'EARTH',
			'FIRE',
			'LIGHT',
			'WATER',
			'WIND'
		];
	}
	public function getTypes()
	{
		// Hardcoded list from YGOPRODeck docs
		return [
			'Aqua',
			'Beast',
			'Beast-Warrior',
			'Creator-God',
			'Cyberse',
			'Dinosaur',
			'Divine-Beast',
			'Dragon',
			'Fairy',
			'Fiend',
			'Fish',
			'Insect',
			'Machine',
			'Plant',
			'Psychic',
			'Pyro',
			'Reptile',
			'Rock',
			'Sea Serpent',
			'Spellcaster',
			'Thunder',
			'Warrior',
			'Winged Beast',
			'Wyrm',
			'Zombie',
			'Normal',
			'Effect',
			'Fusion',
			'Ritual',
			'Synchro',
			'Xyz',
			'Pendulum',
			'Link',
			'Spell',
			'Trap',
			'Toon',
			'Gemini',
			'Tuner',
			'Spirit',
			'Union',
			'Flip'
		];
	}
	public function getRaces()
	{
		// YGO monster, spell, and trap races/properties (from YGOPRODeck docs)
		return [
			'Aqua',
			'Beast',
			'Beast-Warrior',
			'Creator-God',
			'Cyberse',
			'Dinosaur',
			'Divine-Beast',
			'Dragon',
			'Fairy',
			'Fiend',
			'Fish',
			'Insect',
			'Machine',
			'Plant',
			'Psychic',
			'Pyro',
			'Reptile',
			'Rock',
			'Sea Serpent',
			'Spellcaster',
			'Thunder',
			'Warrior',
			'Winged Beast',
			'Wyrm',
			'Zombie',
			'Normal',
			'Effect',
			'Fusion',
			'Ritual',
			'Synchro',
			'Xyz',
			'Pendulum',
			'Link',
			'Spell',
			'Trap',
			'Toon',
			'Gemini',
			'Tuner',
			'Spirit',
			'Union',
			'Flip',
			'Continuous',
			'Counter',
			'Equip',
			'Field',
			'Quick-Play'
		];
	}
}