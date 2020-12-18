<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    // si queremos cambiar los nombres del data
    // y tendremos lo que tiene el ProductResource
    public $collects = ProductResource::class;

    public function toArray($request)
    {
        // para agregar meta-data al ProductCollection
        return [
            'data'  => $this->collection,
            'links' => 'metadata'
        ];
    }
}
