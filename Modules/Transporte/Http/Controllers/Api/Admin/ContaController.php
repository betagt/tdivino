<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Modules\Transporte\Criteria\ContaCriteria;
use Modules\Transporte\Criteria\ModeloCarroCriteria;
use Modules\Transporte\Http\Requests\ContaRequest;
use Modules\Transporte\Repositories\ContaRepository;
use Portal\Http\Controllers\BaseController;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Modelos de carros
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ModeloCarroController extends BaseController
{

	/**
	 * @var ContaRepository
	 */
	private $contaRepository;

	public function __construct(
        ContaRepository $contaRepository)
    {
        parent::__construct($contaRepository, ContaCriteria::class);
		$this->contaRepository = $contaRepository;
	}


    public function getValidator($id = null)
    {
        $this->validator = (new ContaRequest())->rules($id);
        return $this->validator;
    }

}
