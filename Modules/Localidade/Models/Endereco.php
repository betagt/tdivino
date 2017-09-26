<?php

namespace Modules\Localidade\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Endereco extends Model implements Transformable
{
    use TransformableTrait,SoftDeletes;

    protected $fillable = [
        'estado_id','cidade_id', 'bairro_id', 'cep', 'numero', 'endereco', 'complemento'
    ];

    protected $dates = ['deleted_at'];

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function bairro(){
        return $this->belongsTo(Bairro::class, 'cidade_id');
    }
}
