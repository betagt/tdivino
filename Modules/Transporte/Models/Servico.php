<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Servico extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_servicos';

    protected $fillable = [
        'nome',
        'nome_similar',
    ];

    public function tipoDocumentos(){
        return $this->belongsToMany(TipoDocumento::class, 'transporte_servico_tipo_documento_exigidas', 'transporte_servico_id', 'tipo_documento_id');
    }
}
