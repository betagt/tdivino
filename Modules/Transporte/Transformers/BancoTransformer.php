<?php

namespace Modules\Transporte\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Transporte\Models\Banco;

/**
 * Class BancoTransformer
 * @package namespace Portal\Transformers;
 */
class BancoTransformer extends TransformerAbstract
{

	/**
	 * Transform the \Banco entity
	 * @param \Modules\Transporte\Models\Banco $model
	 *
	 * @return array
	 */
	public function transform(Banco $model)
	{
		return [
			'id' => (int)$model->id,
			'codigo' => (int)$model->codigo,
			'nome' => (string)$model->nome,
		];
	}
}
