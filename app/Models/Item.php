<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Item extends Pivot
{
    protected $table = 'items';
	protected $fillable=['order_id','offer_id','quantity','id'];

}
