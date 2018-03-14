<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Movimentacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_financeiro_contas';

    protected $fillable = [
        'valor',
        'saldo',
        'codigo',
        'descricao',
        'tipo',
    ];
}
