<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use Illuminate\Http\Request;

class YgoApiController extends Controller
{
    private $apiService;
    
    public function __construct(YgoApiProxyService $yaps)
    {
        $this->apiService=$yaps;
    }
    
    public function getCardData(){
        
    }
}
