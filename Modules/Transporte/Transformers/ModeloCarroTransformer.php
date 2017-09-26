<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\ModeloCarro;

/**
 * Class ModeloCarroTransformer
 * @package namespace Portal\Transformers;
 */
class ModeloCarroTransformer extends TransformerAbstract
{

    /**
     * Transform the \ModeloCarro entity
     * @param ModeloCarro $model
     *
     * @return array
     */
    public function transform(ModeloCarro $model)
    {
        return [
            'id'         => (int) $model->id,
            'transporte_marca_carro_id'         => (int) $model->transporte_marca_carro_id,
            'nome'         => (string) $model->nome,
        ];
    }
}
