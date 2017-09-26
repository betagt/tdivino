<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Estado extends Model implements Transformable
{
    use TransformableTrait,SoftDeletes;

    protected $fillable = [];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $dates = ['deleted_at'];
}
