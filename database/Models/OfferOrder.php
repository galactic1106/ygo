<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OfferOrder extends Pivot
{
    protected $fillable = ["quantity"];
    public $timestamps = false;
}
