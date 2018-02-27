<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\FinanceiroConta;

/**
 * Class FinanceiroContaTransformer
 * @package namespace Portal\Transformers;
 */
class FinanceiroContaTransformer extends TransformerAbstract
{

    /**
     * Transform the FinanceiroConta entity
     * @param FinanceiroConta $model
     *
     * @return array
     */
    public function transform(FinanceiroConta $model)
    {
        return [
            'id'         => (int) $model->id,

            'valor'=> (double) $model->valor,
            'saldo'=> (double) $model->saldo,
            'codigo'=> (string) $model->codigo,
            'tipo'=> (string) $model->tipo,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
