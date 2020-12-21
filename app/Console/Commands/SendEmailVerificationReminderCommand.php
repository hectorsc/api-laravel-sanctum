<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\SendEmailVerificationNotification;
use App\User;
use Carbon\Carbon;

class SendEmailVerificationReminderCommand extends Command
{
    protected $signature = 'send:reminder';
    protected $description = 'Envía un correo electrónico a los usuarios '. 
    ' que no hayan verificado su cuenta y se registraron hace más de unas semana.';

    public function handle()
    {
        User::query()
            ->whereDate('created_at', '=', Carbon::now()->subDays(7)->format('Y-m-d H:i:s'))
            ->whereNull('email_verified_at')
            ->each(function (User $user) {
                // Equivalente a $this->notify(new VerifyEmail)
                // $user->sendEmailVerificationNotification()
                $user->notify(new SendEmailVerificationNotification());
            });
    }
}
