<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $guarded = [];

    protected $casts = [
        'commission' => 'integer',
        'paddle_vendor_id' => 'integer'
    ];
}
