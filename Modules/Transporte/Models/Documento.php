<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Portal\Models\Imagem;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Documento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'transporte_documentos';

    protected $fillable = [
        'nome',
        'transporte_tipo_documento_id',
        'documentotable_id',
        'documentotable_type',
        'numero',
        'data_vigencia_inicial',
        'data_vigencia_fim',
        'categoria_cnh',
        'status'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($venue) {
            foreach ($venue->arquivo as $b){
                $b->delete();
            }
        });
    }

    public function tipoDocumento(){
        return $this->belongsTo(TipoDocumento::class, 'transporte_tipo_documento_id');
    }

    public function arquivo()
    {
        return $this->morphMany(Imagem::class, 'imagemtable');
    }

}
