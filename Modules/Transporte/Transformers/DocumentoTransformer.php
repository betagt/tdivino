<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Repositories\UserRepository;
use Modules\Core\Transformers\UserTransformer;
use Modules\Transporte\Models\Documento;
use Portal\Transformers\ImagemTransformer;

/**
 * Class DocumentoTransformer
 * @package namespace Portal\Transformers;
 */
class DocumentoTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'tipo_documento',
		'arquivos'
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
            'tipo' => (string)($model->tipoDocumento)?$model->tipoDocumento->nome:null,
            'documentotable_id' => (int)$model->documentotable_id,
            'documentotable_type' => (string)$model->documentotable_type,
            'transporte_tipo_documento_id' => (int)$model->transporte_tipo_documento_id,
            'data_vigencia_inicial' => $model->data_vigencia_inicial,
            'data_vigencia_fim' => $model->data_vigencia_fim,
            'categoria_cnh' => (string)$model->categoria_cnh,

            'numero' => (string)$model->numero,
            'data_emissao' => $model->data_emissao,
            'orgao_amissor' => (string)$model->orgao_amissor,
            'cnae' => (string)$model->cnae,
            'uf' => (string)$model->uf,
            'curso' => (string)$model->curso,
            'carga_horaria' => (string)$model->carga_horaria,
            'data_conclusao' => $model->data_conclusao,
            'nit' => (string) $model->nit,

			'cidade'=> (string) $model->cidade,
			'status'=> (string) $model->status,
			'vistoriador'=> (string) $model->vistoriador,
			'alienado'=> (boolean) $model->alienado,

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

    public function includeArquivos(Documento $model){
        if($model->arquivo->count() == 0){
            return $this->null();
        }
        return $this->collection($model->arquivo, new ImagemTransformer());
    }

}
