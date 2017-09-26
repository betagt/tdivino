<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Localidade\Models\Endereco;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ContratacaoFatura extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'nomefantazia',
        'plano_contratacao_id',
        'tipo_emitente',
        'cpf_cnpj',
        'razaosocial',
        'inscricao_estadual',
        'creci',
        'endereco_diferente',
    ];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];
    public static $_TIPO_EMITENTE = [
        'anunciante' =>'Anúnciante',
        'imobiliaria'=>'Imobiliária',
        'incorporadora'=>'Incorporadora',
        'construtora'  =>'Construtora',
        'autonomo'  =>'Autônomo',
    ];
    public function endereco(){
        return $this->morphOne(Endereco::class,'enderecotable');
    }
}
