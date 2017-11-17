<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Transporte\Criteria\ContaCriteria;
use Modules\Transporte\Criteria\ModeloCarroCriteria;
use Modules\Transporte\Http\Requests\ContaRequest;
use Modules\Transporte\Repositories\ContaRepository;
use Portal\Criteria\OrderCriteria;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Modelos de carros
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ContaController extends BaseController
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

	/**
	 * Consultar
	 *
	 *
	 * Endpoint para consultar todos os Anuncio cadastrados
	 *
	 * Nessa consulta pode ser aplicado os seguintes filtros:
	 *
	 *  - Consultar Normal:
	 *   <br> - Não passar parametros
	 *
	 *  - Consultar por Cidade:
	 *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
	 */
	public function index(Request $request){
		try{
			return $this->defaultRepository
				->pushCriteria(new ContaCriteria($request))
				->pushCriteria(new OrderCriteria($request))
				->paginate(self::$_PAGINATION_COUNT);
		}catch (ModelNotFoundException $e){
			return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
		}
		catch (RepositoryException $e){
			return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
		}
		catch (\Exception $e){
			return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
		}
	}

}
