<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Chamada extends Model implements Transformable
{
    use TransformableTrait;

    const TIPO_SOLICITACAO = 'solicitacao';
    const TIPO_ATENDIMENTO = 'atendimento';

    protected $table = "transporte_chamadas";

    protected $fillable = [
        'fornecedor_id',
        'cliente_id',
        'forma_pagamento_id',
        'tipo',
        'desolamento_km_com_passageiro',
        'desolamento_km_sem_passageiro',
        'datahora_chamado',
        'datahora_comfirmação',
        'datahora_embarque',
        'datahora_desembarcou',
        'valor',
        'observacao',
        'porta_mala',
        'cupon',
        'data_inicial',
        'data_final',
        'timedown',
        'status',
    ];

}
