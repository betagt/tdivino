<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Transporte\Criteria\ModeloCarroCriteria;
use Modules\Transporte\Http\Requests\ModeloCarroRequest;
use Modules\Transporte\Repositories\MarcaCarroRepository;
use Modules\Transporte\Repositories\ModeloCarroRepository;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Modelos de carros
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class ModeloCarroController extends BaseController
{

    /**
     * @var MarcaCarroRepository
     */
    private $modeloCarroRepository;

    public function __construct(
        ModeloCarroRepository $modeloCarroRepository)
    {
        parent::__construct($modeloCarroRepository, ModeloCarroCriteria::class);
        $this->modeloCarroRepository = $modeloCarroRepository;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new ModeloCarroRequest())->rules($id);
        return $this->validator;
    }


    public function todos($marca){
        try{
            return $this->modeloCarroRepository->findByField('transporte_marca_carro_id', $marca);
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
