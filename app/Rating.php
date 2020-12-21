<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Rating extends Pivot
{
    //le decimos que tenemos campos auto incrementables
    public $incrementing = true;
    
    protected $table = 'ratings';

    public function rateable()
    {
        return $this->morphTo();
    }

    public function qualifier()
    {
        return $this->morphTo();
    }

}
