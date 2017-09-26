<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\MarcaCarro;

/**
 * Class MarcaCarroTransformer
 * @package namespace Portal\Transformers;
 */
class MarcaCarroTransformer extends TransformerAbstract
{

    /**
     * Transform the \MarcaCarro entity
     * @param \MarcaCarro $model
     *
     * @return array
     */
    public function transform(MarcaCarro $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome'         => (string) $model->nome,
        ];
    }
}
