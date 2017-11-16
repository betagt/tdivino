<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Conta extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "transporte_contas";

    protected $fillable = [
    	'codigo',
    	'agencia',
    	'conta',
		'variacao',
		'tipo',
		'user_id',
    	'beneficiario',
    	'cpf',
    	'principal',
    	'status',
	];

    protected static function boot()
	{
		parent::boot();
	}

}
