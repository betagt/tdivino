<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Transporte\Criteria\BancoCriteria;
use Modules\Transporte\Criteria\TipoDocumentoCriteria;
use Modules\Transporte\Http\Requests\BancoRequest;
use Modules\Transporte\Http\Requests\ServicoRequest;
use Modules\Transporte\Repositories\BancoRepository;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no levez.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class BancoController extends BaseController
{

	/**
	 * @var BancoRepository
	 */
	private $bancoRepository;

	public function __construct(
        BancoRepository $bancoRepository)
    {
        parent::__construct($bancoRepository, BancoCriteria::class);
		$this->bancoRepository = $bancoRepository;
	}


    public function getValidator($id = null)
    {
        $this->validator = (new BancoRequest())->rules($id);
        return $this->validator;
    }


    public function todos(){
        try{
            return $this->bancoRepository->all();
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
