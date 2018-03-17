<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Core\Models\User;
use Portal\Events\BaseEvent;

class ChamadaMotoristaNoLocal extends BaseEvent implements ShouldBroadcast
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
        dd($this->socket);
        return  [self::checkProd().'chamada.motorista_no_local.cliente.'.$this->uuid];
    }
}

