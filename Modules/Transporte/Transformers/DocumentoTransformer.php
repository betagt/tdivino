<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Transformers\UserTransformer;
use Modules\Transporte\Models\Documento;

/**
 * Class DocumentoTransformer
 * @package namespace Portal\Transformers;
 */
class DocumentoTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'tipo_documento',
        //'usuario',
    ];

    /**
     * Transform the \Documento entity
     * @param \Documento $model
     *
     * @return array
     */
    public function transform(Documento $model)
    {
        return [
            'id' => (int)$model->id,
            'nome' => (string)$model->nome,
            'arquivo' => (string)\URL::to('/') . '/arquivos/img/documentos/' .$model->arquivo,
            'tipo' => (string)$model->tipoDocumento->nome,
            'status' => (string)$model->status,
            'transporte_tipo_documento_id' => (int)$model->transporte_tipo_documento_id,
            'user_id' => (int)$model->user_id,
            'usuario_nome' => (string)$model->usuario->name,
            'usuario_cpf_cnpj' => (string)($model->usuario->pessoa)?$model->usuario->pessoa->cpf_cnpj:null,
            'usuario_rg' => (string)($model->usuario->pessoa)?$model->usuario->pessoa->rg:null,
            'usuario_fantasia' => (string)($model->usuario->pessoa)?$model->usuario->pessoa->fantasia:null,
            'data_vigencia_inicial' => $model->data_vigencia_inicial,
            'data_vigencia_fim' => $model->data_vigencia_fim,
            'categoria_cnh' => (string)$model->categoria_cnh,
            'numero' => (string)$model->numero,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeTipoDocumento(Documento $model)
    {
        if (!$model->tipoDocumento) {
            return null;
        }
        return $this->item($model->tipoDocumento, new TipoDocumentoTransformer());
    }

    public function includeUsuario(Documento $model)
    {
        if (!$model->usuario) {
            return null;
        }
        return $this->item($model->usuario, new UserTransformer());
    }
}
