<?php

namespace Modules\Transporte\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Modules\Core\Models\User;
use Portal\Events\BaseEvent;

class ChamarMotorista extends BaseEvent implements ShouldBroadcast
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
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $uuid, $chamada)
    {
        $this->uuid = $uuid;
        $this->chamada = [
            'data' =>[
                'id'=>$chamada['data']['id'],
                'tipo'=>$chamada['data']['tipo'],
                'forma_pagamento_id'=>$chamada['data']['forma_pagamento_id'],
                'cliente'=>[
                    'data'=>[
                        'name'=>$chamada['data']['cliente']['data']['name'],
                        'imagem'=>$chamada['data']['cliente']['data']['imagem'],
                    ]
                ],
                'trajeto'=>$chamada['data']['trajeto'],
            ]
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return  [self::checkProd().'chamada.motorista'];
    }
}

