<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ModelRated;
use App\Notifications\ModelRatedNotification;

class SendEmailModelRatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ModelRated $event)
    {
        $rateable = $event->getRateable();

        // como es un trait y se usa para product y user
        // preguntamos si es instanceof de producto
        if ($rateable instanceof Product) {

            $notification = new ModelRatedNotification(
                $event->getQualifier()->name,
                $rateable->name, //nombre del producto
                $event->getScore()
            );
            // al user que creo el producto calificado le 
            // mandamos la notificacion
            $rateable->createdBy->notify($notification);
        }
    }
}
