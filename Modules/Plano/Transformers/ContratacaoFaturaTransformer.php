<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Localidade\Transformers\EnderecoTransformer;
use Modules\Plano\Models\ContratacaoFatura;

/**
 * Class ContratacaoFaturaTransformer
 * @package namespace Portal\Transformers;
 */
class ContratacaoFaturaTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['endereco'];

    /**
     * Transform the \ContratacaoFatura entity
     * @param \ContratacaoFatura $model
     *
     * @return array
     */
    public function transform(ContratacaoFatura $model)
    {
        return [
            'id'         => (int) $model->id,
            'nomefantazia' => (string) $model->nomefantazia,
            'plano_contratacao_id' => (int) $model->plano_contratacao_id,
            'tipo_emitente' => (string) $model->tipo_emitente,
            'tipo_emitente_label' => (string) ContratacaoFatura::$_TIPO_EMITENTE[$model->tipo_emitente],
            'cpf_cnpj' => (string) $model->cpf_cnpj,
            'razaosocial' => (string) $model->razaosocial,
            'inscricao_estadual' => (string) $model->inscricao_estadual,
            'creci' => (string) $model->creci,
            'endereco_diferente' => (boolean) $model->endereco_diferente,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeEndereco(ContratacaoFatura $model){
        if(is_null($model->endereco)){
            return null;
        }
        return $this->item($model->endereco, new EnderecoTransformer());
    }
}
