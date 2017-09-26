<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Documento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_documentos';

    protected $fillable = [
        'nome',
        'arquivo',
        'transporte_tipo_documento_id',
        'user_id',
        'numero',
        'data_vigencia_inicial',
        'data_vigencia_fim',
        'categoria_cnh',
        'arquivo',
        'status'
    ];

    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'transporte_tipo_documento_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
