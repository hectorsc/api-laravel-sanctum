<?php

namespace App;

use App\Utils\CanBeRated;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //añadimos nuestro trait para indicar que el product 
    // puede ser calificado
    use CanBeRated;

    protected $guarded = [];

    public function category() 
    {
        // como la clave foránea la tengo en productos
        // la relacion es belongsTo
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
