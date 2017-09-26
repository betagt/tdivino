<?php

namespace Portal\Transformers;

use League\Fractal\TransformerAbstract;
use Portal\Models\MensagemFinanceiro;

/**
 * Class MensagemFinanceiroTransformer
 * @package namespace Portal\Transformers;
 */
class MensagemFinanceiroTransformer extends TransformerAbstract
{

    /**
     * Transform the \MensagemFinanceiro entity
     * @param \MensagemFinanceiro $model
     *
     * @return array
     */
    public function transform(MensagemFinanceiro $model)
    {
        return [
            'id'         => (int) $model->id,
            'user_id'    => (int) $model->user_id,
            'assunto'    => (string) $model->assunto,
            'texto'      => (string) $model->texto,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
