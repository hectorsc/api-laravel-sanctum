<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ModelUnratedNotification extends Notification
{
    use Queueable;

    private string $rateableName;
    private string $qualifierName;

    public function __construct(string $qualifierName, string $rateableName) 
    {
        $this->qualifierName = $qualifierName;
        $this->rateableName = $rateableName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("¡{$this->qualifierName} ha descalificado tu producto {$this->rateableName}!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
