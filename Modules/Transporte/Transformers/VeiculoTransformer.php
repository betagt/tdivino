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
            'marca' => (string)$model->marca->nome,
            'modelo' => (string)$model->modelo->nome,
            'placa' => (string)$model->placa,
            'observacao' => (string)$model->observacao,
            'num_passageiro' => (string)$model->num_passageiro,
            'ano' => (int)$model->ano,
            'ano_modelo_fab' => (int)$model->ano_modelo_fab,
            'cor' => (string)$model->cor,
            'renavam' => (string)$model->renavam,
            'data_licenciamento' => $model->data_licenciamento,
            'tipo_combustivel' => (string)$model->tipo_combustivel,
            'consumo_medio' => (string)$model->consumo_medio,
            'chassi' => (string)$model->chassi,
            'porta_mala_tamanho' => (string)$model->porta_mala_tamanho,
            'arquivo' => (string)$model->arquivo,
            'status' => (string)$model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
