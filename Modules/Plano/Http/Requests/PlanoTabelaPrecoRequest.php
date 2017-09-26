<?php

namespace Modules\Plano\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanoTabelaPrecoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id = null)
    {
        $rules = [
            'id'          => 'integer',
            'plano_id'    => [
                'required',
                'exists:planos,id',
                'integer',
            ],
            'estado_id'   => [
                'required',
                'exists:estados,id',
                'integer'
            ],
            'cidade_id'   => 'required|exists:cidades,id|integer',
            'valor'       => 'required|numeric',
        ];
        // se for edição nao alterar o plano
        if($id){
           unset($rules['plano_id']);
           unset($this['plano_id']);
        }

        return $rules;
    }
}
