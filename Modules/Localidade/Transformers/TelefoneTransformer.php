<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Telefone;

/**
 * Class TelefoneTransformer
 * @package namespace Modules\Localidade\Transformers;
 */
class TelefoneTransformer extends TransformerAbstract
{

    /**
     * Transform the \Telefone entity
     * @param \Telefone $model
     *
     * @return array
     */
    public function transform(Telefone $model)
    {
        return [
            'id'         => (int) $model->id,
            'ddd'        => (int) $model->ddd,
            'numero'     => (string) $model->numero,
            'principal'  => (boolean) $model->principal,
            'tipo'       => (string) $model->tipo,
        ];
    }
}
