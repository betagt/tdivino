<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Telefone extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'ddd',
        'numero',
        'principal',
        'tipo'
    ];

    public function setDddAttribute($value)
    {
        if ($value)
            $this->attributes['ddd'] = preg_replace('([\(\)])', '', $value);
    }

    public function setNumeroAttribute($value)
    {
        if ($value)
            $this->attributes['numero'] = str_replace('-','', $value);
    }
}
