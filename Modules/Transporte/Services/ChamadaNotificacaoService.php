<?php
/**
 * Created by PhpStorm.
 * User: DIX-SUPORTE
 * Date: 26/03/2018
 * Time: 21:04
 */

namespace Modules\Transporte\Services;


class ChamadaNotificacaoService
{

    /**
     * @var ChamadaOneSginalService
     */
    private $chamadaOneSginalService;

    public function __construct(ChamadaOneSginalService $chamadaOneSginalService)
    {
        $this->chamadaOneSginalService = $chamadaOneSginalService;
    }

    public function iniciarChamada($chamada)
    {
        $chamada = [
            'chamada'=>[
                'data' =>[
                    'id' => $chamada['data']['id'],
                    'tipo' => $chamada['data']['tipo'],
                    'forma_pagamento_id' => $chamada['data']['forma_pagamento_id'],
                    'valor' => $chamada['data']['valor'],
                    'km_rodado' => $chamada['data']['km_rodado'],
                    'tx_uso_malha' => $chamada['data']['tx_uso_malha'],
                    'tarifa_operacao' => $chamada['data']['tarifa_operacao'],
                    'valor_repasse' => isset($chamada['data']['valor_repasse']) ? $chamada['data']['valor_repasse'] : null,
                    'veiculo_marca' => isset($chamada['data']['veiculo_marca']) ? $chamada['data']['veiculo_marca'] : null,
                    'veiculo_placa' => isset($chamada['data']['veiculo_placa']) ? $chamada['data']['veiculo_placa'] : null,
                    'veiculo_cor' => isset($chamada['data']['veiculo_cor']) ? $chamada['data']['veiculo_cor'] : null,
                    'veiculo_status' => isset($chamada['data']['veiculo_status']) ? $chamada['data']['veiculo_status'] : null,
                    'veiculo_modelo' => isset($chamada['data']['veiculo_modelo']) ? $chamada['data']['veiculo_modelo'] : null,
                    'cliente' => [
                        'data' => [
                            'name' => $chamada['data']['cliente']['data']['name'],
                            'imagem' => $chamada['data']['cliente']['data']['imagem'],
                        ]
                    ],
                    'trajeto' => $chamada['data']['trajeto'],
                ]
            ]
        ];
        $this->chamadaOneSginalService->sendNotificationUsingTags("Voce possui uma chamada",[[
            'key'=>'chamada_type',
            'relation'=>'is',
            'value'=>checkProd() . 'motorista'],
            [
                'key'=>'motorista_online',
                'relation'=>'is',
                'value'=>'online']
            //'value'=>checkProd() . 'motorista']
        ],null, $chamada);
        /*$this->chamadaOneSginalService->sendNotificationToCategoryAndTag("Voce possui uma chamada", [[
            'key' => 'chamada_type',
            'relation' => 'is',
            'value' => checkProd() . 'motorista']
        ], 'a8e40325-b9cd-4b9b-b88a-a9d7b0baa861', null, $chamada);*/


    }

    public function embarque_motorista($chamada, $uuid){
        $chamada = [
            'chamada'=>[
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
                            'nota_fornecedor' => $chamada['data']['fornecedor']['data']['nota_fornecedor'],
                            'endereco'=>[
                                'data'=>[
                                    $chamada['data']['fornecedor']['data']['endereco']['data']['endereco'],
                                ]
                            ]
                        ]
                    ],
                    'trajeto'=>$chamada['data']['trajeto'],
                ]
            ]
        ];
        $this->chamadaOneSginalService->sendNotificationToCategoryAndTag("Embarque realizado", [[
            'key' => 'chamada_type',
            'relation' => 'is',
            'player_id'=>$uuid,
            'value' => checkProd() . 'motorista']
        ], '8b5eb2d6-b045-4bf7-89ae-f090a9535944', null, $chamada);
    }

    public function cancelar_chamada($mensagem, $uuid, $type){
        $this->chamadaOneSginalService->sendNotificationToCategoryAndTag("Chamada Cancelada", [[
            'key' => 'chamada_type',
            'relation' => 'is',
            'player_id'=>$uuid,
            'value' => checkProd() . $type]
        ], 'a909fae9-7b85-494c-a210-052bfece7b31', null, ['mensagem'=>$mensagem]);
    }

}