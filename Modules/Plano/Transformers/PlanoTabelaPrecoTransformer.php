<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Plano\Models\PlanoTabelaPreco;

/**
 * Class PlanoTabelaPrecoTransformer
 * @package namespace Modules\Plano\Transformers;
 */
class PlanoTabelaPrecoTransformer extends TransformerAbstract
{

    /**
     * Transform the \PlanoTabelaPreco entity
     * @param \PlanoTabelaPreco $model
     *
     * @return array
     */
    public function transform(PlanoTabelaPreco $model)
    {
        return [
            'id'         => (int) $model->id,
            'plano_id'   => $model->plano_id,
            'estado'  => $model->estado,
            'cidade'  => $model->cidade,
            'valor'      => (float) $model->valor,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
