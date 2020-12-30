<?php

namespace App\Providers;

use App\Http\Resources\RatingResource;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;
use App\Rating;

class RatingProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //registrará aquellas clases o servicios
        // que necesitan ser cargadas dentro del container
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //se usa para cargar todos los elementos
        // que no podemos insertarlos en el metodo register
        // es llamado despues de todos los servicios hayan sido registrados
        // creamos un compser que se genera en una vista particular
        // en este caso la vista home y vamos a compartir todos los 
        // rating que tenga el sistema

        // lo que hemos hecho es inicializar una clase o un componente sin haberlo 
        // instanciado de antemano
        view()->composer('home', function (View $view) {
            $view->with('rating', RatingResource::collection(Rating::all())); 
        });
    }
}
