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

    const CLRV_ID = 15;
    const VISTORIA_ID = 12;
    const SEGURO_ID = 13;

	const STATUS_PENDENTE = 'pendente';
	const STATUS_ACEITO = 'aceito';
	const STATUS_INVALIDO = 'invalido';

    protected $table = 'transporte_documentos';

    protected $fillable = [
        'nome',
        'transporte_tipo_documento_id',
        'documentotable_id',
        'documentotable_type',
        'numero',
        'numero',
        'data_vigencia_inicial',
        'data_vigencia_fim',
        'categoria_cnh',
        'data_emissao',
        'orgao_amissor',
        'cnae',
        'uf',
        'curso',
        'carga_horaria',
        'data_conclusao',
        'nit',
		'atividade_remunerada',
		'cidade',
		'vistoriador',
		'alienado',
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
