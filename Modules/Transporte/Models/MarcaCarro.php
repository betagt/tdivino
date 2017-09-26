<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MarcaCarro extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_marca_carros';

    protected $fillable = [
        'nome'
    ];

}
