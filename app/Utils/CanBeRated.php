<?php

namespace App\Utils;

// este trait es para los modelos que pueden ser calificados
trait CanBeRated
{
   public function qualifiers(string $model = null)
   {
      $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

      return $this->morphToMany($modelClass, 'rateable', 'ratings', 'rateable_id', 'qualifier_id')
         ->withPivot('qualifier_type', 'score')
         ->wherePivot('qualifier_type', $modelClass)
         ->wherePivot('rateable_type', $this->getMorphClass());
   }

   // calculamos el promedio 
   public function averageRating(string $model = null)
   {
      // si la calificacion que esta relacionada con el modelo que me pasan
      // vamos a calcular el promedio de la columna score y si no 0.0
      return $this->qualifiers($model)->avg('score') ?: 0.0;

   }

}