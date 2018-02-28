<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Portal\Events\BaseEvent;

class RemoverChamada extends BaseEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;



    /**
     * @var int
     */
    public $idChamada;

    /**
     * @var string
     */
    public $status;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $idChamada, string $status)
    {
        $this->idChamada = $idChamada;
        $this->status = $status;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return  [self::checkProd().'chamada.remove'];
    }
}
