<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\Servico;

/**
 * Class ServicoTransformer
 * @package namespace Portal\Transformers;
 */
class ServicoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Servico entity
     * @param \Servico $model
     *
     * @return array
     */
    public function transform(Servico $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome'         => (string) $model->nome,
            'nome_similar'         => (string) $model->nome_similar,
            'habilidades_values'         => ($model->tipoDocumentos->count() > 0)? $model->tipoDocumentos->pluck('id')->toArray() : null,
            'habilidades_labels'         => ($model->tipoDocumentos->count() > 0)? $model->tipoDocumentos->pluck('nome')->toArray() : null,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
