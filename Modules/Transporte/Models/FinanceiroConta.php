<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FinanceiroConta extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_financeiro_contas';

    protected $fillable = [
        'valor',
        'saldo',
        'codigo',
        'tipo',
        'descricao',
        'user_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
