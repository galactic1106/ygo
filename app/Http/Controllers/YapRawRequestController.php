<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;

class YapRawRequestController extends Controller
{
    /**
     * Handle the incoming request.
     *paam string $url
     *
     * @param  YgoApiProxySrvice  $yaps
     **/
    public function __invoke(string $url, YgoApiProxyService $yaps): array
    {
        return $yaps->makeRawRequest($url);
    }
}
