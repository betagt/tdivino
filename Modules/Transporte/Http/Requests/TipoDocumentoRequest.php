<?php

namespace Modules\Transporte\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDocumentoRequest extends FormRequest
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
    public function rules($id)
    {
        return [
            'nome'=>'required|max:255',
            'descricao'=>'string|nullable|max:500',
            'observacao'=>'string|nullable|max:255',
            'precisa_de_documento'=>'boolean|nullable',
        ];
    }

}
