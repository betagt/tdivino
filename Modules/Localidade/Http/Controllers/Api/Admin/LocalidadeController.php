<?php

namespace Modules\Localidade\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Localidade\Repositories\BairroRepository;
use Modules\Localidade\Repositories\CidadeRepository;
use Modules\Localidade\Repositories\EstadoRepository;
use Modules\Localidade\Repositories\LocalidadeRepository;
use Modules\Localidade\Services\GeoService;
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
     * @var GeoService
     */
    private $geoService;

    public function __construct(
        CidadeRepository $cidadeRepository,
        EstadoRepository $estadoRepository,
        BairroRepository $bairroRepository,
        GeoService $geoService,
        LocalidadeRepository $localidadeRepository)
    {

        $this->cidadeRepository = $cidadeRepository;
        $this->estadoRepository = $estadoRepository;
        $this->bairroRepository = $bairroRepository;
        $this->geoService = $geoService;
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

    public function getSinglePosition($cidade,$endereco,$estado){
        $status = $this->geoService->getSinglePosition($cidade,$endereco,$estado);

        if(!$status){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, 'Local não encontrada');
        }
        else
        {
            return $status;
        }
    }

}
