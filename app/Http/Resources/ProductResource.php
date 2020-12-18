<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        // lo que devolvemos al usuario final
        // cuando hagamos una peticion rest (en este caso get)
        // en el postman veremos .... 
        // {"data":{"id":1,"name":"Rachel Kuphal","price":44516}}
        return [
            'id' => (int) $this->id,
            'name' => (string) $this->name,
            'price' => (float) $this->price
        ];
    }
}
