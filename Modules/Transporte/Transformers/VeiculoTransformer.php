<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\Veiculo;

/**
 * Class VeiculoTransformer
 * @package namespace Portal\Transformers;
 */
class VeiculoTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['documentos'];
    /**
     * Transform the \Veiculo entity
     * @param \Modules\Transporte\Models\Veiculo $model
     *
     * @return array
     */
    public function transform(Veiculo $model)
    {
        return [
            'id' => (int)$model->id,
            'transporte_marca_carro_id' => (int)$model->transporte_marca_carro_id,
            'transporte_modelo_carro_id' => (int)$model->transporte_modelo_carro_id,
            'user_id' => (int)$model->user_id,
            'usuario_nome' => ($model->usuario)?(string)$model->usuario->name:null,
            'proprietario' => ($model->usuario)?(string)$model->usuario->name:null,
            'marca' => (string)$model->marca->nome,
            'modelo' => (string)$model->modelo->nome,
            'placa' => (string)$model->placa,
            'observacao' => (string)$model->observacao,
            'num_passageiro' => (string)$model->num_passageiro,
            'ano' => (int)$model->ano,
            'ano_modelo_fab' => $model->ano_modelo_fab,
            'cor' => (string)$model->cor,
            'renavam' => (string)$model->renavam,
            'data_licenciamento' => $model->data_licenciamento,
            'tipo_combustivel' => (string)$model->tipo_combustivel,
            'consumo_medio' => (string)$model->consumo_medio,
            'chassi' => (string)$model->chassi,
            'porta_mala_tamanho' => (string)$model->porta_mala_tamanho,
            'status' => (string)$model->status,
            'habilitado' => (string)$model->habilitado,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeDocumentos(Veiculo $model){
        if($model->documento->count() == 0){
            return $this->null();
        }
        return $this->collection($model->documento, new DocumentoTransformer());
    }

}
