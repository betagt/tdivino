<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TipoDocumento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_tipo_documentos';

    protected $fillable = [
        'nome',
        'descricao',
        'observacao',
        'precisa_de_documento',
    ];

}
