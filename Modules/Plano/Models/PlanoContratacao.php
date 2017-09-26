<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Anuncio\Models\Anuncio;
use Modules\Core\Models\User;
use Modules\Localidade\Models\Endereco;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PlanoContratacao extends Model implements Transformable
{
    const STATUS_ATIVO = 'ativo';
    const STATUS_PENDENTE = 'pendente';
    const STATUS_CANCELADO = 'cancelado';
    const STATUS_FINALIZADO = 'finalizado';

    use TransformableTrait,Auditable,SoftDeletes;

    protected $fillable = [
        'plano_id',
        'user_id',
        'numero_fatura',
        'data_inicio',
        'data_fim',
        'total',
        'desconto',
        'status',
    ];

    public function plano(){
        return $this->belongsTo(Plano::class,'plano_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function ultimoLancamentoPago(){
        return $this->hasMany(Lancamento::class,'plano_contratacao_id')->where('data_do_pagamento','<>',null)->orderBy('data_do_pagamento','desc')->limit(1);
    }

    public function anuncios(){
        return $this->belongsToMany(Anuncio::class, 'anuncio_contratacaos', 'plano_contratacao_id','anuncio_id');
    }

    public function anuncio(){
        return $this->belongsToMany(Anuncio::class, 'anuncio_contratacaos', 'plano_contratacao_id','anuncio_id')->orderBy('id','desc')->limit(1);
    }

    public function fatura(){
        return $this->hasOne(ContratacaoFatura::class, 'plano_contratacao_id', 'id');
    }

    public function endereco(){
        return $this->morphOne(Endereco::class,'enderecotable');
    }
}
