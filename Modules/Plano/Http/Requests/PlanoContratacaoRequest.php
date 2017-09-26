<?php

namespace Modules\Plano\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanoContratacaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contratacao'=>'required',
            'contratacao.plano_id'=>'required|exists:planos,id',
            'contratacao.user_id'=>'required|exists:users,id|integer',
            'contratacao.total'=>'numeric|nullable',
            'contratacao.desconto'=>'numeric|nullable',
            'contratacao.anuncio_id'=>'required|integer',
            'fatura'=>'required',
            'fatura.razaosocial' => 'string',
            'fatura.tipo_emitente' => 'string',
            'fatura.cnpj_cpf' => 'string',
            'endereco.estado_id'    =>'required_if:endereco.estado_id,>,0|exists:estados,id|nullable',
            'endereco.cidade_id'    =>'required_if:endereco.estado_id,>,0|exists:cidades,id|nullable',
            'endereco.bairro_id'    =>'required_if:endereco.estado_id,>,0|exists:bairros,id|nullable',
            'endereco.cep'          =>'required_if:endereco.estado_id,>,0|nullable',
            'endereco.numero'       =>'required_if:endereco.estado_id,>,0|nullable',
            'endereco.endereco'     =>'required_if:endereco.estado_id,>,0|nullable',
        ];
    }
}
