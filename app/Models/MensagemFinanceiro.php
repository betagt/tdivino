<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MensagemFinanceiro extends Model implements Transformable
{
    use TransformableTrait, Auditable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'assunto',
        'texto',
    ];
}
