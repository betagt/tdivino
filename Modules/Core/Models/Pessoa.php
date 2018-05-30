<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Localidade\Models\Cidade;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Pessoa extends Model implements Transformable
{
    use TransformableTrait;

    const PESSOA_FISICA = 1;
    const PESSOA_JURIDICA = 2;

    protected $fillable = [
        'cpf_cnpj',
        'nec_especial',
        'data_nascimento',
        'rg', 'orgao_emissor',
        'escolaridade',
        'sexo',
        'estado_civil',
        'fantasia',
        'contato',
        'contato_segudo',
        'telefone_contato',
        'telefone_segundo_contato',
        'tipo_sanguineo',
        'naturalidade',
    ];


    public function setCpfCnpjAttribute($value)
    {
        if ($value)
            $this->attributes['cpf_cnpj'] = preg_replace('([\.\-\/])', '', $value);
    }

    public function getCpfCnpjAttribute($value)
    {
        if(is_null($value))
            return null;
        if(validar_cnpj($value)) {
            return mask($this->attributes['cpf_cnpj'], '##.###.###/####-##');
        }
        return mask($this->attributes['cpf_cnpj'], '###.###.###-##');
    }

    public function tipo(){
        return (validar_cnpj($this->attributes['cpf_cnpj']))?self::PESSOA_JURIDICA:self::PESSOA_FISICA;
    }

    public function naturalidade(){
        return $this->belongsTo(Cidade::class, 'naturalidade');
    }
}
