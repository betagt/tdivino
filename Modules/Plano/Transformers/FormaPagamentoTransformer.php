<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Plano\Models\FormaPagamento;

/**
 * Class FormaPagamentoTransformer
 * @package namespace Modules\Plano\Transformers;
 */
class FormaPagamentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \FormaPagamento entity
     * @param \FormaPagamento $model
     *
     * @return array
     */
    public function transform(FormaPagamento $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome'=> (string) $model->nome,
            'taxa'=> (float) $model->taxa,
            'status'=> (boolean) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
