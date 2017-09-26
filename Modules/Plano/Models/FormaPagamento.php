<?php

namespace Modules\Plano\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FormaPagamento extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $fillable = [
        'nome', 'taxa', 'status', 'slug',
    ];

    protected $dates = ['deleted_at'];

    public function setCpfCnpjAttribute($value)
    {
            $this->attributes['slug'] = str_slug($this->attributes['nome']);
    }

}
