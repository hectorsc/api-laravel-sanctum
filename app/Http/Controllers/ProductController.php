<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Product;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum")->except(["index", "show"]);
    // }
    
    public function index()
    {
        // como aquí tenemos que devolver Product::all()
        // y eso es una collection hacemos lo siguiente.
        // return ProductResource::collection(Product::all());
        // como nos hemos creado un ProductCollection lo usamos ahora
        return new ProductCollection(Product::all());
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return $product;
    }

    public function show(Product $product)
    {
        $product = new ProductResource($product);
        return $product;  
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json();
    }
}
