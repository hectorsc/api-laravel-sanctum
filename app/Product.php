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

    // esto es un evento de eloquent
    // LO MOVEMOS A UN OBSERVER
    // protected static function booted()
    // {
    //     // se ejecuta antes de crearse la entidad que en este caso es producto
    //     static::creating(function (Product $product) {
    //         $faker = \Faker\Factory::create();
    //         $product->image_url = $faker->imageUrl();
    //         // cada vez que se crea un producto se le asigna el usuario que está logeado
    //         $product->createdBy()->associate(auth()->user());
    //     });
    // }

}
