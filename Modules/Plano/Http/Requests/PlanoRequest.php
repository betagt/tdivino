<?php

namespace Modules\Plano\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanoRequest extends FormRequest
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
        $rules = [
            'id'              => 'integer',
            'nome'            => 'required|string|max:255',
            'dias'            => 'required|integer',
            'qtde_destaque'   => 'required|integer',
            'qtde_anuncio'    => 'required|integer',
            'valor'           => 'required|numeric',
            'tipo'            => 'required|string|in:anunciante,imobiliaria,qimob-erp',
            'status'          => 'required|boolean',
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->all();
            $rules['nome'] = 'required|string|max:255|'.Rule::unique('planos')->where(function ($query) use ($data) {
                $query->where('nome', $data['nome']);
                $query->where('tipo', $data['tipo']);
            });
        }

        return $rules;
    }
}
