<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Transporte\Criteria\MarcaCarroCriteria;
use Modules\Transporte\Http\Requests\MarcaCarroRequest;
use Modules\Transporte\Repositories\MarcaCarroRepository;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Modelos de carros
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class MarcaCarroController extends BaseController
{

    /**
     * @var MarcaCarroRepository
     */
    private $marcaCarroRepository;

    public function __construct(
        MarcaCarroRepository $marcaCarroRepository)
    {
        parent::__construct($marcaCarroRepository, MarcaCarroCriteria::class);
        $this->marcaCarroRepository = $marcaCarroRepository;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new MarcaCarroRequest())->rules($id);
        return $this->validator;
    }


    public function todos(){
        try{
            return $this->marcaCarroRepository->all();
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
