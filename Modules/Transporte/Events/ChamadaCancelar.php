<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ChamadaCancelar implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var
     */
    public $chamada;

	/**
	 * @var
	 */
	private $type;


	/**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $uuid, $chamada, $type)
    {
        $this->uuid = $uuid;
        $this->chamada = $chamada;
		$this->type = $type;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  ["chamada.cancelar.$this->type.".$this->uuid];
    }
}