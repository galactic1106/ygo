<?php
namespace App\Services;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class YgoApiProxyService
{
    private string $cardDataEndpoint = 'https://db.ygoprodeck.com/api/v7/cardinfo.php';
    private string $imageEndpoint = 'https://images.ygoprodeck.com/images';
    private string $cardArchetypesEndPoint = 'https://db.ygoprodeck.com/api/v7/archetypes.php';
    private string $cardImgEndpoint;
    private string $smallImgEndpoint;
    private string $croppedImgEndpoint;

    private string $cardImgLocation = 'images/cardImgs/';
    private string $smallImgLocation = 'images/smallImgs/';
    private string $croppedImgLocation = 'images/croppedImgs/';

    private int $requestPerSecond = 18;
    private string $requestThisSecondKey = 'ApiRequestsThisSecond';
    private Carbon $limitResetTime;

    public function __construct()
    {
        $this->cardImgEndpoint = $this->imageEndpoint . '/cards/';
        $this->smallImgEndpoint = $this->imageEndpoint . '/cards_small/';
        $this->croppedImgEndpoint = $this->imageEndpoint . '/cards_cropped/';
    }

    private function rateLimit(): void
    {
        while (
            Cache::remember($this->requestThisSecondKey, now()->addSecond(), function () {
                $this->limitResetTime = now()->addSecond();
                return 0;
            }) >= $this->requestPerSecond
        ) {
            time_sleep_until((float) $this->limitResetTime->format('U.u'));
            usleep(rand(0, 1000));
        }
        Cache::increment($this->requestThisSecondKey);
    }
    /**
     * @param array<int,mixed> $params
     */
    public function getCardData(array $params): ?array
    {
        $this->rateLimit();
        try {
            $request = Http::timeout(60)->get($this->cardDataEndpoint, $params);
            Cache::add('request_' . md5(http_build_query($params)), $request->body());
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
            return Storage::disk('public')->url($imgPath);
        }
        try {
            $request = Http::timeout(30)->get($imgUrl);
        } catch (ConnectException $e) {
            return null;
        }
        Storage::disk('public')->put($imgPath, $request->body());
        return Storage::disk('public')->url($imgPath);
    }

    /**
     * @param string $cardType The type of card. Accepts 'monster', 'spell', 'trap', or 'all'.
     * @return string[] An array of race names.
     */
    public function getRaces(string $cardType='all'):array{
        $allRaces=
        [
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
        'Counter'
        ];
        $monsterRaces=
        [
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
        'Zombie'
        ];
        $spellRaces=[
        'Normal',
        'Field',
        'Equip',
        'Continuous',
        'Quick-Play',
        'Ritual'
        ];
        $trapRaces=[
        'Normal',
        'Continuous',
        'Counter'
        ];
        $ret=[];
        switch ($cardType)
        {
            case 'all':
            default:
            $ret=$allRaces;
            break;
            case 'monster':
            $ret=$monsterRaces;
            break;
            case 'spell':
            $ret=$spellRaces;
            break;
            case 'trap':
            $ret=$trapRaces;
            break;
        }
        return $ret;
    }
}
