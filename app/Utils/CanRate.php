<?php

namespace App\Utils;

use App\Events\ModelRated;

// creamos un trait para darselo a todos los modelos que puedan calificar
trait CanRate
{
   // creamos la relación
   public function ratings(Model $model = null)
   {
      // model si existe y si no existe retornamos del modelo
      // el classname del modelo al que hacemos referencia
      $modelClass = $model ? $model : $this->getMorphClass();

      // creamos la relacion
      $morphToMany = $this->morphToMany(
         $modelClass, // nombre de la clase a la que quiero relacionarme
         'qualifier', // nombre de mi relacion
         'ratings', // nombre de la tabla
         'qualifier_id', //columna con la que hago relacion
         'rateable_id' // la columna con la que quiero relacionarme
      );

      $morphToMany
         ->as('rating') // creamos un alias
         ->withTimestamps() //trabajamos con campo fecha
         ->withPivot('score', 'rateable_type') //cada vez que llamo a la relacion me trae score y rateable_type
         ->wherePivot('rateable_type', $modelClass) //añadimos los siguientes where
         // donde la tabla pivot rateable_type sea igual a la clase que le pasamos como variable
         ->wherePivot('qualifier_type', $this->getMorphClass()); //el qualifier_type sea igual al getMorphClass
      
      return $morphToMany;

   }

   public function rate(Model $model, float $score)
   {
      // para no calificar dos veces al mismo modelo
      if ($this->hasRated($model)) {
         return false;
      }

      // llamamos a la relacion y guardamos en la tabla
      $this->ratings($model)->attach($model->getKey(), [
         'score' => $score,
         'rateable_type' => get_class($model)
      ]);

      // evento para cada vez que se califique una entidad
      event(new ModelRated($this, $model, $score ));

      return true;
   }

   public function unrate(Model $model): bool
   {
      if (!$this->hasRated($model)) {
         return false;
      }

      $this->ratings($model->getMorphClass())->detach($model->getKey());

      // disparamos evento cada vez que se descalifica una entidad
      event(new ModelUnrated($this, $model));

      return true;
   }

   public function hasRated (Model $model)
   {
      // si es nulo la relacion de ratings del modelo que le pasamos con el id
      // que le pasamos retornamos falso
      return ! is_null($this->ratings($model->getMorphClass())->find($model->getKey()));

   }


}