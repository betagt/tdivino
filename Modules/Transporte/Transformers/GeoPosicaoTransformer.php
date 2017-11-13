<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\GeoPosicao;

/**
 * Class GeoPosicaoTransformer
 * @package namespace Portal\Transformers;
 */
class GeoPosicaoTransformer extends TransformerAbstract
{

    /**
     * Transform the \GeoPosicao entity
     * @param \Modules\Transporte\Models\GeoPosicao $model
     *
     * @return array
     */
    public function transform(GeoPosicao $model)
    {
        return [
            'id'         => (int) $model->id,
            'user_id'         => (int) $model->user_id,
            'endereco'         => (string) $model->endereco,
            'lat'         => (double) $model->lat,
            'lng'         => (double) $model->lng,
            'passageiro'         => (boolean) $model->passageiro,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
