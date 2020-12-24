<?php

namespace App\Listeners;

use App\Notifications\ModelUnratedNotification;
use App\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ModelUnrated;

class SendEmailModelUnratedNotification implements ShouldQueue
{
    public function handle(ModelUnrated $event)
    {
        $rateable = $event->getRateable();

        if($rateable instanceof Product) {
            $notification = new ModelUnratedNotification(
                $event->getQualifier()->name,
                $rateable->name
            );
            $rateable->createdBy()->notify($notification);
        }
        
    }
}
