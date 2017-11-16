<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\Conta;

/**
 * Class ContaTransformer
 * @package namespace Portal\Transformers;
 */
class ContaTransformer extends TransformerAbstract
{

	/**
	 * Transform the \Conta entity
	 * @param \Modules\Transporte\Models\Conta $model
	 *
	 * @return array
	 */
	public function transform(Conta $model)
	{
		return [
			'id' => (int)$model->id,
			'user_id' => (int)$model->user_id,
			'codigo' => (int)$model->codigo,
			'agencia' => (string)$model->agencia,
			'conta' => (string)$model->conta,
			'variacao' => (string)$model->variacao,
			'tipo' => (string)$model->tipo,
			'beneficiario' => (string)$model->beneficiario,
			'cpf' => (string)$model->cpf,
			'principal' => (boolean)$model->principal,
			'status' => (string)$model->status,
			'created_at' => $model->created_at,
			'updated_at' => $model->updated_at
		];
	}
}
