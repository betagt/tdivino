<?php

namespace Modules\Plano\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Anuncio\Transformers\AnuncioTransformer;
use Modules\Plano\Models\PlanoContratacao;

/**
 * Class PlanoContratacaoTransformer
 * @package namespace Modules\Plano\Transformers;
 */
class PlanoContratacaoTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['ultimo_lancamento_pago', 'ultimo_anuncio','fatura','plano_ativo'];
    //protected $availableIncludes = ['plano'];
    /**
     * Transform the \PlanoContratacao entity
     * @param \PlanoContratacao $model
     *
     * @return array
     */
    public function transform(PlanoContratacao $model)
    {
        return [
            'id' => (int)$model->id,
            'plano_id' => (int)$model->plano_id,
            'plano' => (string)$model->plano->nome,
            'anunciante' => (string)$model->user->name,
            'user_id' => (int)$model->user_id,
            'numero_fatura' => (string)$model->numero_fatura,
            'data_inicio' => (string)$model->data_inicio,
            'data_fim' => (string)$model->data_fim,
            'total' => (double)$model->total,
            'desconto' => (double)$model->desconto,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeUltimoLancamentoPago(PlanoContratacao $model){
        if(is_null($model->ultimoLancamentoPago)){
            return $this->null();
        }

        return $this->collection($model->ultimoLancamentoPago, new LancamentoTransformer());
    }

    public function includeUltimoAnuncio(PlanoContratacao $model){
        if($model->anuncio->count() == 0){
            return $this->null();
        }
        return $this->item($model->anuncio->first(), new AnuncioTransformer());
    }

    public function includeFatura(PlanoContratacao $model){
        if(is_null($model->fatura)){
            return $this->null();
        }

        return $this->item($model->fatura, new ContratacaoFaturaTransformer());
    }

    public function includePlanoAtivo(PlanoContratacao $model){
        if(is_null($model->plano)){
            return $this->null();
        }

        return $this->item($model->plano, new PlanoTransformer());
    }
}
