<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FinalizarChamada implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    private $uuid;
    /**
     * @var
     */
    public $message;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $uuid, $message)
    {
        $this->uuid = $uuid;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  ['chamada.cacelada.motorista.'.$this->uuid];
    }
}
