<?php

namespace App\Listeners;

use App\Models\MeuPerfil;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class EmailVerificadoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        MeuPerfil::create([
            'created_at' => now() , 
            'users_id' => $event->user->id ]) ;
    }
}
