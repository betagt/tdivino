<?php

namespace Modules\Plano\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormaPagamentoRequest extends FormRequest
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

    public function rules()
    {
        $id = null;
        if($this->route())
            $id = $this->route()->parameter('forma_pagamento');

        $rules = [
            'nome' =>[
                'required',
                "unique:forma_pagamentos,nome".(is_null($id)?'':",$id"),
            ],
            'taxa'=>[
                'required',
                'numeric'
            ],
            'status'=>[
                'required',
                'boolean'
            ],
        ];
        return $rules;
    }
}
