<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class GeoPosicao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_geo_posicaos';

    protected $fillable = [
        'user_id',
        'transporte_chamada_id',
        'transporte_geo_posicaotable_id',
        'transporte_geo_posicaotable_type',
        'endereco',
        'lat',
        'lng',
        'passageiro',
    ];

}
