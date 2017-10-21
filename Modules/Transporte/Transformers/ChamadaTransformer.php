<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Core\Transformers\UserTransformer;
use Modules\Plano\Transformers\LancamentoTransformer;
use Modules\Transporte\Models\Chamada;

/**
 * Class ChamadaTransformer
 * @package namespace Portal\Transformers;
 */
class ChamadaTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['fornecedor', 'cliente', 'lancamentos'];
    /**
     * Transform the \Chamada entity
     * @param Chamada $model
     *
     * @return array
     */
    public function transform(Chamada $model)
    {
        return [
            'id'         => (int) $model->id,
            'fornecedor_id'=> (int) $model->fornecedor_id,
            'cliente_id'=> (int) $model->cliente_id,
            'tipo'=> (string) $model->tipo,
            'desolamento_km_com_passageiro'=> (double) $model->desolamento_km_com_passageiro,
            'desolamento_km_sem_passageiro'=> (double) $model->desolamento_km_sem_passageiro,
            'datahora_chamado'=> $model->datahora_chamado,
            'datahora_comfirmação'=> $model->datahora_comfirmação,
            'datahora_embarque'=> $model->datahora_embarque,
            'datahora_desembarcou'=> $model->datahora_desembarcou,
            'valor'=> (double) $model->valor,
            'observacao'=> (string) $model->observacao,
            'porta_mala'=> (int) $model->porta_mala,
            'cupon'=> (string) $model->cupon,
            'data_inicial'=> $model->data_inicial,
            'data_final'=> $model->data_final,
            'timedown'=> $model->timedown,
            'status'=> (string) $model->status,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeFornecedor(Chamada $model){
        if(is_null($model->fornecedor)){
            return $this->null();
        }
        return $this->item($model->fornecedor, new UserTransformer());
    }

    public function includeCliente(Chamada $model){
        if(is_null($model->fornecedor)){
            return $this->null();
        }
        return $this->item($model->cliente, new UserTransformer());
    }
    public function includeLancamentos(Chamada $model){
        if($model->lancamentos->count() == 0){
            return $this->null();
        }
        return $this->collection($model->lancamentos, new LancamentoTransformer());
    }
}
