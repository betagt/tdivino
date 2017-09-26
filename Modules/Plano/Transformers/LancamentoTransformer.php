<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Plano\Models\Lancamento;

/**
 * Class LancamentoTransformer
 * @package namespace Portal\Transformers;
 */
class LancamentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Lancamento entity
     * @param \Lancamento $model
     *
     * @return array
     */
    public function transform(Lancamento $model)
    {
        return [
            'id'         => (int) $model->id,
            'forma_pagamento_id' => (int) $model->forma_pagamento_id,
            'codigo' => (string) $model->codigo,
            'plano_contratacao_id'=> (int) $model->plano_contratacao_id,
            'valor' => (double) $model->valor,
            'valor_liquido' => (double) $model->valor_liquido,
            'taxa' => (double) $model->taxa,
            'desconto' => (double) $model->desconto,
            'data_do_pagamento' => $model->data_do_pagamento,
            'ultima_atualizacao' => $model->ultima_atualizacao,
            'status' => $model->status,
            'status_label' => Lancamento::$statusListLabel[$model->status],
            'metodo' => $model->metodo,
            'link_externo' => $model->link_externo,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeFormaPagamento(Lancamento $model){
        if(is_null($model->forma_pagamento)){
            return null;
        }
        return $this->item($model->forma_pagamento, new FormaPagamentoTransformer());
    }

    public function includePlanoContratacao(Lancamento $model){
        if(is_null($model->plano_contratacao)){
            return null;
        }
        return $this->item($model->plano_contratacao, new PlanoContratacaoTransformer());
    }
}
