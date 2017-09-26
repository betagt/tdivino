<?php

namespace Portal\Transformers;

use League\Fractal\TransformerAbstract;
use Portal\Models\Pagina;

/**
 * Class PaginaTransformer
 * @package namespace Portal\Transformers;
 */
class PaginaTransformer extends TransformerAbstract
{

    /**
     * Transform the \Pagina entity
     * @param \Pagina $model
     *
     * @return array
     */
    public function transform(Pagina $model)
    {
        return [
            'id'         => (int) $model->id,
            'titulo'     => $model->titulo,
            'slug'       => $model->slug,
            'descricao'  => $model->descricao,
            'resumo'     => $model->resumo,
            'status'     => $model->status,
            'pai'        => $model->pai,
        ];
    }

}
