<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Plano\Models\Plano;

/**
 * Class PlanoTransformer
 * @package namespace Modules\Plano\Transformers;
 */
class PlanoTransformer extends TransformerAbstract
{

    public $availableIncludes = ['tabela_preco',];

    /**
     * Transform the \Plano entity
     * @param \Plano $model
     *
     * @return array
     */
    public function transform(Plano $model)
    {
        return [
            'id'            => (int)$model->id,
            'nome'          => $model->nome,
            'dias'          => (int)$model->dias,
            'qtde_destaque' => (int)$model->qtde_destaque,
            'qtde_anuncio'  => (int)$model->qtde_anuncio,
            'valor'         => (float)$model->valor,
            'tipo'          => $model->tipo,
            'tipo_label'    => Plano::$_TIPO[$model->tipo],
            'gratis'        => (boolean) $model->_gratis(),
            'status'        => $model->status,
            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at
        ];
    }

    public function includeTabelaPreco(Plano $model)
    {
        if (!$model->tabela_preco) {
            return $this->null();
        }
        return $this->collection($model->tabela_preco, new PlanoTabelaPrecoTransformer());
    }



}
