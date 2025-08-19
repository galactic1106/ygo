<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use Illuminate\Http\Request;

class YapRawRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $url, YgoApiProxyService $yaps):array
    {
       return $yaps->makeRawRequest($url);
    }
}
