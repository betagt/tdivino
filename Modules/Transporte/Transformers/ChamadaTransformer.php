<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\UserTransformer;
use Modules\Plano\Transformers\LancamentoTransformer;
use Modules\Transporte\Models\Chamada;

/**
 * Class ChamadaTransformer
 * @package namespace Portal\Transformers;
 */
class ChamadaTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['fornecedor', 'cliente', 'lancamentos', 'trajeto'];
    /**
     * Transform the \Chamada entity
     * @param Chamada $model
     *
     * @return array
     */
    public function transform(Chamada $model)
    {
        $chamada = [
            'id'         => (int) $model->id,
            'fornecedor_id'=> (int) $model->fornecedor_id,
            'forma_pagamento_id'=> (int) $model->forma_pagamento_id,
            'cliente_id'=> (int) $model->cliente_id,
            'cliente_nome' => (string)  ($model->cliente)?$model->cliente->name:null,
            'tipo'=> (string) $model->tipo,
            'desolamento_km_com_passageiro'=> (double) $model->desolamento_km_com_passageiro,
            'desolamento_km_sem_passageiro'=> (double) $model->desolamento_km_sem_passageiro,
            'datahora_chamado'=> $model->datahora_chamado,
            'datahora_comfirmação'=> $model->datahora_comfirmação,
            'datahora_embarque'=> $model->datahora_embarque,
            'datahora_desembarcou'=> $model->datahora_desembarcou,
            'valor'=> (double) $model->valor,
            'observacao'=> (string) $model->observacao,
            'porta_mala'=> (int) $model->porta_mala,
            'avaliacao'=> (int) $model->avaliacao,
            'datahora_encerramento'=> $model->datahora_encerramento,
            'cupon'=> (string) $model->cupon,
            'data_inicial'=> $model->data_inicial,
            'data_final'=> $model->data_final,
            'timedown'=> $model->timedown,
            'km_rodado'=> $model->km_rodado,
            'tx_uso_malha'=> $model->tx_uso_malha,
            'tarifa_operacao'=> $model->tarifa_operacao,
            'valor_repasse'=> $model->valor_repasse,
            'status'=> (string) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
        if(!is_null($model->fornecedor)){
            $chamada = array_merge($chamada, [
                'fornecedor_nome' => $model->fornecedor->name
            ]);
            if(!is_null($model->fornecedor->veiculoAtivo)){
                $chamada = array_merge($chamada, [
                    'veiculo_marca' => $model->fornecedor->veiculoAtivo->marca->nome,
                    'veiculo_placa' => $model->fornecedor->veiculoAtivo->placa,
                    'veiculo_cor' => $model->fornecedor->veiculoAtivo->cor,
                    'veiculo_status' => $model->fornecedor->veiculoAtivo->status,
                    'veiculo_modelo' => $model->fornecedor->veiculoAtivo->modelo->nome
                ]);
            }
        }
        return $chamada;
    }

    public function includeFornecedor(Chamada $model){
        if(is_null($model->fornecedor)){
            return $this->null();
        }
        return $this->item($model->fornecedor, new UserTransformer());
    }

    public function includeCliente(Chamada $model){
        if(is_null($model->cliente)){
            return $this->null();
        }
        return $this->item($model->cliente, new UserTransformer());
    }

    public function includeLancamentos(Chamada $model){
        if($model->lancamentos->count() == 0){
            return $this->null();
        }
        return $this->collection($model->lancamentos, new LancamentoTransformer());
    }

    public function includeTrajeto(Chamada $model){
        if($model->trajeto->count() == 0){
            return $this->null();
        }
        return $this->collection($model->trajeto, new GeoPosicaoTransformer());
    }
}
