<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Portal\Events\BaseEvent;

class ChamadaDesembarque extends BaseEvent implements ShouldBroadcast
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
        $this->chamada = $this->chamada = [
            'data' =>[
                'id'=>$chamada['data']['id'],
                'tipo'=>$chamada['data']['tipo'],
                'forma_pagamento_id'=>$chamada['data']['forma_pagamento_id'],
                'veiculo_marca' => $chamada['data']['veiculo_marca'],
                'veiculo_placa' => $chamada['data']['veiculo_placa'],
                'veiculo_cor' => $chamada['data']['veiculo_cor'],
                'veiculo_status' => $chamada['data']['veiculo_status'],
                'veiculo_modelo' => $chamada['data']['veiculo_modelo'],
                'fornecedor'=>[
                    'data'=>[
                        'name'=>$chamada['data']['fornecedor']['data']['name'],
                        'email'=>$chamada['data']['fornecedor']['data']['email'],
                        'imagem'=>$chamada['data']['fornecedor']['data']['imagem'],
                        'lat'=>$chamada['data']['fornecedor']['data']['lat'],
                        'lng'=>$chamada['data']['fornecedor']['data']['lng'],
                    ]
                ],
                'trajeto'=>$chamada['data']['trajeto'],
            ]
        ];
		$this->type = $type;
	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  [self::checkProd()."chamada.desembarque.$this->type.".$this->uuid];
    }
}