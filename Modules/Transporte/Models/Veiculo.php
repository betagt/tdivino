<?php

namespace Modules\Transporte\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Veiculo extends Model implements Transformable
{

	const ACEITO = "aceito";
	const INVALIDO = "invalido";
	const PENDENTE = "pendente";

	use TransformableTrait;

    protected $fillable = [
        'user_id',
        'transporte_marca_carro_id',
        'transporte_modelo_carro_id',
        'placa',
        'observacao',
        'num_passageiro',
        'ano',
        'ano_modelo_fab',
        'cor',
        'renavam',
        'data_licenciamento',
        'tipo_combustivel',
        'consumo_medio',
        'chassi',
        'porta_mala_tamanho',
        'arquivo',
        'status',
    ];

    protected $table = 'transporte_veiculos';

    public function marca(){
        return $this->belongsTo(MarcaCarro::class, 'transporte_marca_carro_id');
    }

    public function modelo(){
        return $this->belongsTo(ModeloCarro::class, 'transporte_modelo_carro_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documento()
    {
        return $this->morphMany(Documento::class, 'documentotable');
    }

    public function crlAtivo(){
		return $this->morphOne(Documento::class, 'documentotable')->where('principal', '=', true);
	}

    public function vistoriaAtivo(){
		return $this->morphOne(Documento::class, 'documentotable')->where('principal', '=', true);
	}

    public function seguroAtivo(){
		return $this->morphOne(Documento::class, 'documentotable')->where('principal', '=', true);
	}

}
