<?php

namespace Modules\Localidade\Http\Controllers\Api\Front;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Modules\Localidade\Criteria\LocalidadeViewCriteria;
use Modules\Localidade\Repositories\BairroRepository;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Modules\Localidade\Repositories\LocalidadeViewRepository;
use Modules\Localidade\Services\CepService;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

class LocalidadeController extends BaseController
{

    /**
     * @var CidadeRepository
     */
    private $cidadeRepository;
    /**
     * @var EstadoRepository
     */
    private $estadoRepository;

    /**
     * @var EstadoRepository
     */
    private $bairroRepository;

    /**
     * @var LocalidadeRepository
     */
    private $localidadeRepository;
    /**
     * @var CepService
     */
    private $cepService;
    /**
     * @var LocalidadeViewRepository
     */
    private $localidadeViewRepository;

    public function __construct(
        CidadeRepository $cidadeRepository,
        EstadoRepository $estadoRepository,
        BairroRepository $bairroRepository,
        LocalidadeRepository $localidadeRepository,
        LocalidadeViewRepository $localidadeViewRepository,
        CepService $cepService)
    {

        $this->cidadeRepository = $cidadeRepository;
        $this->estadoRepository = $estadoRepository;
        $this->bairroRepository = $bairroRepository;
        $this->localidadeRepository = $localidadeRepository;
        $this->cepService = $cepService;
        $this->localidadeViewRepository = $localidadeViewRepository;
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        return [];
    }

    public function selectBairros($cidadeId){
        try{
            return $this->bairroRepository->findWhere(['cidade_id'=>$cidadeId]);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function selectCidades($estadoId){
        try{
            return $this->cidadeRepository->findWhere(['estado_id'=>$estadoId]);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function selectEstados(){
        try{
            return $this->estadoRepository->all();
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function localidadeByCep($cep){
        try{
            return $this->cepService->requestCep($cep);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

    public function filterLocalidade(Request $request){
        try{
            return $this->localidadeViewRepository->pushCriteria(new LocalidadeViewCriteria($request))->paginate(15);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'message'=>$e->getMessage()]));
        }
    }

}
