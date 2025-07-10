<?php

namespace App\Http\Controllers;

use App\Services\YgoApiProxyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    private YgoApiProxyService $yaps;
    
    public function __construct(YgoApiProxyService $yaps)
    {
        $this->yaps=$yaps;
    }
    
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $latestMonsters = $this->yaps->getCardData([
            'type'=> implode(',',$this->yaps->getTypes('main monsters')),
            'race'=> implode(',', $this->yaps->getRaces('monster')),
            'sort'=> 'new',
            'num'=> 20,
            'offset'=>0
        ]);
        //dd($this->yaps->getTypes('main monsters'),$latestMonsters);
        
        $latestSpells=$this->yaps->getCardData([
            'type'=>'spell card',
            'sort'=> 'new',
            'num'=> 20,
            'offset'=>0
        ]);
        
        $latestTraps=$this->yaps->getCardData([
            'type'=>'trap card',
            'sort'=> 'new',
            'num'=> 20,
            'offset'=>0
        ]);
        
        $latestExtra=$this->yaps->getCardData([
            'type'=>implode(',',$this->yaps->getTypes('extra')),
            'sort'=> 'new',
            'num'=> 20,
            'offset'=>0
        ]);
        
        return Inertia::render('Home',[
            'latestMonsters'=>$latestMonsters ?? [],
            'latestSpells'=> $latestSpells ?? [],
            'latestTraps'=> $latestTraps ?? [],
            'latestExtra'=> $latestExtra ?? [],
        ]);
    }
}
