<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Modules\Plano\Models\Lancamento;
use Modules\Transporte\Models\GeoPosicao;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Chamada extends Model implements Transformable
{
    use TransformableTrait;

    const TIPO_SOLICITACAO = 'solicitacao';
    const TIPO_ATENDIMENTO = 'atendimento';
    const TIPO_FINALIZADO= 'finalizado';

    const STATUS_PENDENTE = 'pendente';
    const STATUS_PAGO = 'pago';
    const STATUS_CANCELADO = 'cancelado';

    protected $table = "transporte_chamadas";

    protected $fillable = [
        'fornecedor_id',
        'cliente_id',
        'tipo',
        'desolamento_km_com_passageiro',
        'desolamento_km_sem_passageiro',
        'datahora_chamado',
        'datahora_comfirmação',
        'datahora_embarque',
        'datahora_desembarcou',
        'valor',
        'avaliacao',
        'observacao',
        'porta_mala',
        'cupon',
        'data_inicial',
        'data_final',
        'timedown',
        'status',
		'km_rodado',
		'tx_uso_malha',
		'tarifa_operacao',
		'valor_repasse',
    ];
    public function lancamentos()
    {
        return $this->morphMany(Lancamento::class, 'lancamentotable');
    }

    public function trajeto()
    {
        return $this->morphMany(GeoPosicao::class, 'transporte_geo_posicaotable_type');
    }

    public function fornecedor(){
        return $this->belongsTo(User::class, 'fornecedor_id');
    }

    public function cliente(){
        return $this->belongsTo(User::class, 'cliente_id');
    }

}
