<?php

namespace Modules\Localidade\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Models\Endereco;

/**
 * Class EnderecoTransformer
 * @package namespace Modules\Localidade\Transformers;
 */
class EnderecoTransformer extends TransformerAbstract
{

    /**
     * Transform the \Endereco entity
     * @param \Endereco $model
     *
     * @return array
     */
    public function transform(Endereco $model)
    {
        return [
            'id'            => (int) $model->id,
            'estado_id'     => (int) $model->estado_id,
            'cidade_id'     => (int) $model->cidade_id,
            'bairro_id'     => (int) $model->bairro_id,
            'cep'           => (string) $model->cep,
            'numero'        => (string) $model->numero,
            'endereco'      => (string) $model->endereco,
            'complemento'   => (string) $model->complemento,
            'cidade'        => (string) ($model->cidade)?$model->cidade->titulo:null,
            'estado'        => (string) ($model->estado)?$model->estado->titulo:null,
            'estado_uf'     => (string) ($model->estado)?$model->estado->uf:null,
            'bairro'        => (string) ($model->bairro)?$model->bairro->titulo:null
            /*'created_at' => $model->created_at,
            'updated_at' => $model->updated_at*/
        ];
    }
}
