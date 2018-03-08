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
                'valor'=>$chamada['data']['valor'],
                'km_rodado'=> $chamada['data']['km_rodado'],
                'tx_uso_malha'=> $chamada['data']['tx_uso_malha'],
                'tarifa_operacao'=> $chamada['data']['tarifa_operacao'],
                'valor_repasse'=> isset($chamada['data']['valor_repasse'])?$chamada['data']['valor_repasse']:null,
                'veiculo_marca' => isset($chamada['data']['veiculo_marca'])?$chamada['data']['veiculo_marca']:null,
                'veiculo_placa' => isset($chamada['data']['veiculo_placa'])?$chamada['data']['veiculo_placa']:null,
                'veiculo_cor' => $chamada['data']['veiculo_cor'],
                'veiculo_status' => isset($chamada['data']['veiculo_status'])?$chamada['data']['veiculo_status']:null,
                'veiculo_modelo' => isset($chamada['data']['veiculo_modelo'])?$chamada['data']['veiculo_modelo']:null,
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

