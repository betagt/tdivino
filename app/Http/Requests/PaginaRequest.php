<?php

namespace Portal\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class PaginaRequest extends FormRequest
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
            $id = $this->route()->parameter('pagina');

        $rules = [
            'id'        => 'integer',
            'titulo'    => 'required|string|max:255|unique:paginas,titulo'.(isset($id)?','.$id:''),
            'slug'      => 'string|max:255',
            'descricao' =>'required|string',
            'resumo'    => 'string|max:500',
            'status'    =>'required|boolean|in:1,0',
            'parent_id' => 'integer'
        ];

        return $rules;
    }
}
