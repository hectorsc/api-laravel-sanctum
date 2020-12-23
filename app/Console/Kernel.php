<?php

namespace App\Console;

use App\Console\Commands\SendEmailVerificationReminderCommand;
use App\Console\Commands\SendNewsletterCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendNewsletterCommand::class,
        SendEmailVerificationReminderCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // // definimos las tareas programadas
        // $schedule->command('inspire')->hourly();
        $schedule->command('inspire')
            // comando se ejecuta en modo mantenimiento
            // y se activa con php artisan down
            // php artisan up se para .... duda??
            ->evenInMaintenanceMode()
            // para hacer un log de lo que está pasando
            ->sendOutputTo(storage_path('inspire.log'))
            ->everyMinute();
        // // Podemos ejecutar comandos usando funciones anonimas
        // $schedule->call(function (){
        //     echo "hola";
        // })->everyFiveMinutes();
        $schedule->command(SendNewsletterCommand::class)
            // evita la superposicion de tareas
            // si ya hay una tarea de la misma instancia corriendo no se ejecuta
            ->withoutOverlapping()
            //por si nuestra aplicacion se ejecuta en varios servidores con esto sólo lo hará en uno
            ->onOneServer() 
            ->mondays();
        $schedule->command(SendEmailVerificationReminderCommand::class)
            ->onOneServer()
            ->daily();
        
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
