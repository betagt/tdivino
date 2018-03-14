<?php

namespace Modules\Transporte\Events;

use Illuminate\Queue\SerializesModels;

class GerarContaAPagas
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conta)
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
