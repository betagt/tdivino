<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Arquivo extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
