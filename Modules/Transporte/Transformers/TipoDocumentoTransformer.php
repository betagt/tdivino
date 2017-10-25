<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\TipoDocumento;

/**
 * Class HabilidadeTransformer
 * @package namespace Portal\Transformers;
 */
class TipoDocumentoTransformer extends TransformerAbstract
{

    /**
     * Transform the \TipoDocumento entity
     * @param \TipoDocumento $model
     *
     * @return array
     */
    public function transform(TipoDocumento $model)
    {
        return [
            'id'         => (int) $model->id,
            'nome' => (string) $model->nome,
            'descricao' => (string) $model->descricao,
            'observacao' => (string) $model->observacao,
            'precisa_de_documento' => (boolean) $model->precisa_de_documento,
            'tipo' => (string) $model->tipo,
            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
