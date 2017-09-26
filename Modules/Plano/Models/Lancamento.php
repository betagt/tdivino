<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Lancamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'forma_pagamento_id',
        'plano_contratacao_id',
        'valor',
        'desconto',
        'data_do_pagamento',
        'codigo',
        'ultima_atualizacao',
        'status',
        'valor_liquido',
        'taxa',
        'metodo',
        'link_externo',
    ];

    public static $statusListLabel = array(
        0 => 'Iniciado',
        1 => 'Aguardando pagamento',
        2 => 'Em Análise',
        3 => 'Pago',
        4 => 'Disponível',
        5 => 'Em Disputa',
        6 => 'Devolvido',
        7 => 'Cancelado',
        8 => 'Estornado',
        9 => 'Contestação'
    );

    public function forma_pagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    public function plano_contratacao()
    {
        return $this->belongsTo(PlanoContratacao::class, 'plano_contratacao_id');
    }

}
