<?php

namespace Modules\Plano\Http\Controllers\Api\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Portal\Http\Controllers\BaseController;
use Modules\Plano\Repositories\PlanoRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Plano de Anúncio - Frontend
 *
 * Essa API é responsável pelo gerenciamento de planos de anúncio no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 *
 * Class PlanoController
 * @package Portal\Http\Controllers\Api
 */
class PlanoController extends BaseController
{
    /**
     * @var PlanoRepository
     */
    private $planoRepository;


    public function __construct(PlanoRepository $planoRepository)
    {
        $this->planoRepository = $planoRepository;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        return $this->validator;
    }

    /**
     * Consulta Planos
     *
     * Endpoint para consulta de planos no frontend.
     *
     * @param $id
     * @return retorna um registro
     */
    public function indexPlano($tipo_anunciante, $estado, $cidade){
        try{
            return $this->planoRepository
                ->findByTipoClienteEstadoCidade($tipo_anunciante, $estado, $cidade);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            dd($e->getMessage());
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }
}
