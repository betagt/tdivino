<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pagina extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, Auditable;

    protected $fillable = [
        'parent_id', 'titulo','descricao', 'resumo','status'
    ];

    protected  $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    function pai(){
        return $this->hasOne(Pagina::class,'parent_id', 'id');
    }

    public function setTituloAttribute($value)
    {
       $this->attributes['titulo'] = $value;
       $this->attributes['slug'] = str_slug($value);
    }
}
