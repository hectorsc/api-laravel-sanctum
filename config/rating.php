<?php

// modelo que  vamos a usar y la calificacion
// de 1 hasta 5
return [
   'models' => [
      'rating' => \App\Rating::class
   ],
   'from' => 1,
   'to' => 5,
   // esto no se muy bien para que se añade
   'required_approval' => true,
];