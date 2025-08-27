<?php
namespace App\Services;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class YgoApiProxyService
{
    private string $cardDataEndpoint = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
    private string $imageEndpoint = 'https://images.ygoprodeck.com/images';
    private string $cardArchetypesEndPoint = 'https://db.ygoprodeck.com/api/v7/archetypes.php';
    private string $randomCardEndpoint = 'https://db.ygoprodeck.com/api/v7/randomcard.php';
    private string $cardImgEndpoint;
    private string $smallImgEndpoint;
    private string $croppedImgEndpoint;

    private string $cardImgLocation = 'images/cardImgs/';
    private string $smallImgLocation = 'images/smallImgs/';
    private string $croppedImgLocation = 'images/croppedImgs/';

    private int $requestsPerSecond = 18;
    private string $requestThisSecondKey = 'ApiRequestsThisSecond';
    private Carbon $limitResetTime;
    private int $cacheDuration = 48; //in hours

    public function __construct()
    {
        $this->cardImgEndpoint = $this->imageEndpoint . '/cards/';
        $this->smallImgEndpoint = $this->imageEndpoint . '/cards_small/';
        $this->croppedImgEndpoint = $this->imageEndpoint . '/cards_cropped/';
    }

    private function rateLimit(): void
    {
        while (
            Cache::memo()->remember($this->requestThisSecondKey, now()->addSecond(), function () {
                $this->limitResetTime = now()->addSecond();
                return 0;
            }) >= $this->requestsPerSecond
        ) {
            time_sleep_until((float) $this->limitResetTime->format('U.u'));
            usleep(rand(0, 1000));
        }
        Cache::increment($this->requestThisSecondKey);
    }

    public function makeRawRequest(string $url): ?array
    {
        if (!Str::contains($url, $this->cardDataEndpoint)) {
            return null;
        }

        $cacheKey = 'request_' . md5($url);
        return Cache::remember($cacheKey, now()->addHours($this->cacheDuration), function () use ($url) {
            $this->rateLimit();
            try {
                $request = Http::timeout(60)->get($url);
                return $request->json();
            } catch (ConnectException $e) {
                return null;
            }
        });
    }

    /**
     * @param array<int,mixed> $params
     */
    public function getCardData(array $params): ?array
    {
        $cacheKey = 'request_' . md5(http_build_query($params));
        if (!isset($params['num']) || $params['num'] > 100) {
            $params['num'] = 20;
            if (!isset($params['offset'])) {
                $params['offset'] = 0;
            }
        }
        return Cache::remember($cacheKey, now()->addHours($this->cacheDuration), function () use ($params) {
            $this->rateLimit();
            try {
                $request = Http::timeout(60)->get($this->cardDataEndpoint, $params);
                return $request->json();
            } catch (ConnectException $e) {
                return null;
            }
        });
    }

    public function getRandomCard(): array|null
    {
        $this->rateLimit();
        try {
            $request = Http::timeout(60)->get($this->randomCardEndpoint);
            return $request->json();
        } catch (ConnectException $e) {
            return null;
        }
    }

    public function getCardImage(string $id, string $size = 'card'): string|null
    {
        $imgPath = '';
        $imgUrl = '';
        switch ($size) {
            case 'cropped':
                $imgPath = $this->croppedImgLocation . $id . '.jpg';
                $imgUrl = $this->croppedImgEndpoint . $id . '.jpg';
                break;
            case 'small':
                $imgPath = $this->smallImgLocation . $id . '.jpg';
                $imgUrl = $this->smallImgEndpoint . $id . '.jpg';
                break;
            case 'card':
            default:
                $imgPath = $this->cardImgLocation . $id . '.jpg';
                $imgUrl = $this->cardImgEndpoint . $id . '.jpg';
                break;
        }
        if (Storage::disk('public')->exists($imgPath)) {
            return Storage::disk('public')->path($imgPath);
        }
        try {
            if (
                Cache::remember($imgPath . 'tried', now()->addDay(), function () {
                    return false;
                })
            ) {
                return null;
            }
            $this->rateLimit();
            $request = Http::timeout(30)->get($imgUrl);
            if ($request->status() !== 200) {
                Cache::set($imgPath . 'tried', true, now()->addDay());
                return null;
            }
        } catch (ConnectException $e) {
            return null;
        }
        Storage::disk('public')->put($imgPath, $request->body());
        return Storage::disk('public')->path($imgPath);
    }

    /**
     * @param string $cardType The type of card. Accepts 'monster', 'spell', 'trap', or 'all'.
     * @return string[] An array of race names.
     */
    public function getRaces(string $cardType = 'all'): array
    {
        $allRaces = [
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
            'Field',
            'Equip',
            'Quick-Play',
            'Ritual',
            'Counter',
        ];
        $monsterRaces = [
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
        ];
        $spellRaces = ['Normal', 'Field', 'Equip', 'Continuous', 'Quick-Play', 'Ritual'];
        $trapRaces = ['Normal', 'Continuous', 'Counter'];
        $ret = [];
        switch ($cardType) {
            case 'all':
            default:
                $ret = $allRaces;
                break;
            case 'monster':
                $ret = $monsterRaces;
                break;
            case 'spell':
                $ret = $spellRaces;
                break;
            case 'trap':
                $ret = $trapRaces;
                break;
        }
        return $ret;
    }

    /**
     * @param string $cardType accepted values: 'all','main','main monsters','extra','other','spells','traps';
     * @return array<int,string>
     */
    public function getTypes(string $cardType = 'all'): array
    {
        $all = [
            'Effect Monster',
            'Flip Effect Monster',
            'Flip Tuner Effect Monster',
            'Gemini Monster',
            'Normal Monster',
            'Normal Tuner Monster',
            'Pendulum Effect Monster',
            'Pendulum Effect Ritual Monster',
            'Pendulum Flip Effect Monster',
            'Pendulum Normal Monster',
            'Pendulum Tuner Effect Monster',
            'Ritual Effect Monster',
            'Ritual Monster',
            'Spell Card',
            'Spirit Monster',
            'Toon Monster',
            'Trap Card',
            'Tuner Monster',
            'Union Effect Monster',
            'Fusion Monster',
            'Link Monster',
            'Pendulum Effect Fusion Monster',
            'Synchro Monster',
            'Synchro Pendulum Effect Monster',
            'Synchro Tuner Monster',
            'XYZ Monster',
            'XYZ Pendulum Effect Monster',
            'Skill Card',
            'Token',
        ];
        $main = [
            'Effect Monster',
            'Flip Effect Monster',
            'Flip Tuner Effect Monster',
            'Gemini Monster',
            'Normal Monster',
            'Normal Tuner Monster',
            'Pendulum Effect Monster',
            'Pendulum Effect Ritual Monster',
            'Pendulum Flip Effect Monster',
            'Pendulum Normal Monster',
            'Pendulum Tuner Effect Monster',
            'Ritual Effect Monster',
            'Ritual Monster',
            'Spirit Monster',
            'Toon Monster',
            'Tuner Monster',
            'Union Effect Monster',
        ];
        $mainMonsters = [
            'Effect Monster',
            'Flip Effect Monster',
            'Flip Tuner Effect Monster',
            'Gemini Monster',
            'Normal Monster',
            'Normal Tuner Monster',
            'Pendulum Effect Monster',
            'Pendulum Effect Ritual Monster',
            'Pendulum Flip Effect Monster',
            'Pendulum Normal Monster',
            'Pendulum Tuner Effect Monster',
            'Ritual Effect Monster',
            'Ritual Monster',
            'Spirit Monster',
            'Toon Monster',
            'Tuner Monster',
            'Union Effect Monster',
        ];
        $spells = ['Spell Card'];
        $traps = ['Trap Card'];
        $extra = [
            'Fusion Monster',
            'Link Monster',
            'Pendulum Effect Fusion Monster',
            'Synchro Monster',
            'Synchro Pendulum Effect Monster',
            'Synchro Tuner Monster',
            'XYZ Monster',
            'XYZ Pendulum Effect Monster',
        ];
        $other = ['Skill Card', 'Token'];

        $ret = [];
        switch ($cardType) {
            case 'main':
                $ret = $main;
                break;
            case 'extra':
                $ret = $extra;
                break;
            case 'other':
                $ret = $other;
                break;
            case 'main monsters':
                $ret = $mainMonsters;
                break;
            case 'spells':
                $ret = $spells;
                break;
            case 'traps':
                $ret = $traps;
                break;
            case 'all':
            default:
                $ret = $all;
                break;
        }

        return $ret;
    }

    /**
     * @return array<int,string>
     */
    public function getFrameTypes(): array
    {
        $frameTypes = [
            'normal',
            'effect',
            'ritual',
            'fusion',
            'synchro',
            'xyz',
            'link',
            'normal_pendulum',
            'effect_pendulum',
            'ritual_pendulum',
            'fusion_pendulum',
            'synchro_pendulum',
            'xyz_pendulum',
            'spell',
            'trap',
            'token',
            'skill ',
        ];
        return $frameTypes;
    }

    /**
     * @return array<int, string>
     */
    public function getArchetypes(): array
    {
        $cacheKey = 'archetypes_list';
        return Cache::remember($cacheKey, now()->addHours(24), function () {
            $this->rateLimit();
            try {
                $response = Http::timeout(60)->get($this->cardArchetypesEndPoint);
                if ($response->failed() || !is_array($response->json())) {
                    return []; // Return an empty array on failure or malformed response
                }
                // Pluck the 'archetype_name' from each object and return as a simple array
                return collect($response->json())->pluck('archetype_name')->all();
            } catch (ConnectException $e) {
                return []; // Return an empty array on connection error
            }
        });
    }

    public function getAttributes(): array
    {
        $attributes = ['dark', 'light', 'earth', 'water', 'fire', 'wind', 'divine'];
        return $attributes;
    }

    public function getLinkMarkers()
    {
        $linkMarkers = ['top', 'bottom', 'left', 'right', 'bottom-left', 'bottom-right', 'top-left', 'top-right'];
        return $linkMarkers;
    }

    public function getBanLists()
    {
        $banLists = ['tcg', 'ocg', 'goat'];
        return $banLists;
    }
    public function getSortables()
    {
        $sortables = ['atk', 'def', 'name', 'type', 'level', 'id', 'new'];
        return $sortables;
    }

    public function getFormats()
    {
        $formats = ['tcg', 'goat', 'ocg goat', 'speed duel', 'master duel', 'rush duel', 'duel links'];
        return $formats;
    }

    public function getRegions()
    {
        $regions = ['tcg', 'ocg'];
        return $regions;
    }
}
