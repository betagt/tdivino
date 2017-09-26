<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Localidade\Models\Cidade;
use Modules\Localidade\Models\Estado;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PlanoTabelaPreco extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, Auditable;

    protected $fillable = [
        'plano_id', 'estado_id', 'cidade_id', 'valor'
    ];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
    public function planos()
    {
        return $this->belongsTo(Plano::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

}
