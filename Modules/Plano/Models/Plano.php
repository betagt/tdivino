<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Localidade\Models\Cidade;
use Modules\Localidade\Models\Estado;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Plano extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, Auditable;

    protected $fillable = [
        'nome', 'dias', 'qtde_destaque', 'qtde_anuncio', 'valor', 'tipo', 'status'
    ];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public static $_TIPO = [
        'anunciante' =>'Anunciante',
        'imobiliaria'=>'Imobiliaria',
        'qimob-erp'  =>'Qimob ERP',
    ];

    public function tabela_preco()
    {
        return $this->hasMany(PlanoTabelaPreco::class);
    }

    public function cidade()
    {
        return $this->belongsToMany(Cidade::class, 'plano_tabela_precos', 'cidade_id', 'plano_id');
    }

    public function estado()
    {
        return $this->belongsToMany(Estado::class, 'plano_tabela_precos', 'estado_id', 'plano_id');
    }

    public function _gratis(){
        return $this->getAttribute('valor') == 0;
    }

}


