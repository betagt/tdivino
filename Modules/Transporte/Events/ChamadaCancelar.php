<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Portal\Events\BaseEvent;

class ChamadaCancelar extends BaseEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var
     */
    public $mensagem;

	/**
	 * @var
	 */
	private $type;


	/**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $uuid, $mensagem, $type)
    {
        $this->uuid = $uuid;
        $this->mensagem = $mensagem;
		$this->type = $type;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  [self::checkProd()."chamada.cancelar.$this->type.".$this->uuid];
    }
}