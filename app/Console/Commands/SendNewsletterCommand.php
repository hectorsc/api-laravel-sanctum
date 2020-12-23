<?php

namespace App\Console\Commands;

use App\Notifications\NewsletterNotification;
use Illuminate\Console\Command;
use App\User;
use App\Product;
use Illuminate\Support\Facades\DB;

class SendNewsletterCommand extends Command
{
    // agregamos un argumento al comando opcional para enviar
    // solo a los correos deseados de tipo array => * opcional => ?
    protected $signature = 'send:newsletter 
                            {emails?*} : Correos Electrónicos a los cuales enviar directamente
                            {--s|schedule : Si debe ser ejecutado directamente o no}';
    protected $description = 'Envía un correo electronico a todos los usuarios que hayan verificado su cuenta';

    
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userEmails = $this->argument('emails');
        $schedule = $this->option('schedule');

        $builder = User::query();

        if ($userEmails) {
            $builder->whereIn('email', $userEmails);
        }

        $builder->whereNotNull('email_verified_at');
        $count = $builder->count();

        if ($count) {
            $this->info("Se enviarán {$count} correos");

            if ($this->confirm('¿Estás de acuerdo?') || $schedule) {

                $productQuery = Product::query();
                // Productos mejor calificados
                $productQuery->withCount(['qualifications as average_rating' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(score),0)'));
                }])->orderByDesc('average_rating');

                $products = $productQuery->take(6)->get();

                $this->output->progressStart($count);

                $builder->each(function (User $user) use ($products) {
                    $user->notify(new NewsletterNotification($products->toArray()));
                    $this->output->progressAdvance();
                });

                $this->output->progressFinish();
                $this->info('Correos enviados');
                return;
            } 
        }

        $this->info('No se enviaron correos'); 
    }
}
