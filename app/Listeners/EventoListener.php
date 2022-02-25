<?php

namespace App\Listeners;

use App\Notifications\EventoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class EventoListener
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
    public function handle($event)
    {
        /*Cliente::all()->except($user->id)
            ->each(function (Cliente $cliente) use ($evento) {
                $cliente->notify(new EventoNotification($evento));
            });*/
        $clienteInTheEvent = $event->evento->asistenUsuarios;
        Notification::send($clienteInTheEvent, new EventoNotification($event->evento));
    }
}
