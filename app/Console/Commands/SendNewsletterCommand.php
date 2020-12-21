<?php

namespace App\Console\Commands;

use App\Notifications\NewsletterNotification;
use Illuminate\Console\Command;
use App\User;

class SendNewsletterCommand extends Command
{
    // agregamos un argumento al comando opcional para enviar
    // solo a los correos deseados de tipo array => * opcional => ?
    protected $signature = 'send:newsletter {emails?*}';
    protected $description = 'Envía un correo electrónico con la newsletter';

    public function handle()
    {
        $emails = $this->argument('emails');
        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();
        
        // si tenemos usuarios enviamos la notificiación
        if ($count) {
            $this->output->progressStart($count);
            // usuarios que hayan verificado su correo electronico
            $builder->whereNotNull('email_verified_at')
                ->each(function (User $user) {
                    $user->notify(new NewsletterNotification());
                    $this->output->progressAdvance();
                    $this->info("\n". ' Usuario verificado, enviamos correo');
                });
            $this->output->progressFinish();
            $this->info("De los {$count} usuarios registrados en el sistema, se enviaron {$builder->count()} correos");

        } else {
            $this->info("\n" . 'No se envió ningun correo');
        }
    }
}
