<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RatingResource;
use App\Product;
use App\Rating;
use Illuminate\Support\Facades\Gate;

class ProductRatingController extends Controller
{
    public function rate(Product $product, Request $request)
    {
        $this->validate($request, [
            'score' => 'required'
        ]);

        $user = $request->user();
        $user->rate($product, $request->get('score'));

        return new ProductResource($product);
    }

    public function unrate(Product $product, Request $request)
    {
        $user = $request->user();
        $user->unrate($product);

        return new ProductResource($product);
    }

    // definimos el metodo para aprobar
    public function approve(Rating $rating)
    {
        // para utilizar la politica que acabamos de crear
        Gate::authorize('admin', $rating);

        $rating->approve();
        $rating->save();

        return response()->json();
    }

    // para que el admin pueda probar cada uno
    // de los recursos creamos un listado
    public function list(Request $request)
    {
        Gate::authorize('admin');
        // consultamos los rating
        $builder = Rating::query();

        // con el campo creado dentro de la config
        // si tenemos approved
        //para probar esto en postman la ruta sería .../api/rating?approved=true
        if ($request->has('approved'))
        $builder->whereNotNull('approved_at');

        // en este caso la ruta en postman sería .../api/rating?notApproved=true
        if ($request->has('notApproved'))
        $builder->whereNull('approved_at');

        return RatingResource::collection($builder->get());
    }
    
}
