<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /*
    * Cast an TEXT field to array.
    */
    protected $casts = [
        'board' => 'array'
    ];

    
}
