<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ModeloCarro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_modelo_carros';

    protected $fillable = [
        'transporte_marca_carro_id',
        'nome',
    ];

    public function marca(){
        return $this->belongsTo(MarcaCarro::class, 'transporte_marca_carro_id');
    }

}
