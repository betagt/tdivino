<?php

namespace Modules\Transporte\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'user_id' =>'required|integer|exists:users,id',
            'transporte_marca_carro_id' =>'required|integer|exists:transporte_marca_carros,id',
            'transporte_modelo_carro_id' =>'required|integer|exists:transporte_modelo_carros,id',
            'ano' =>'required|integer',
            'placa' =>'required|string',
            'cor' =>'required|string',
            'arquivo' =>'required|string',
        ];
    }

}
