<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;

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

    // escribimos dentro de la propiedad approved_at
    // la fecha actual
    public function approve()
    {
        $this->approved_at = Carbon::now();
    }

}
