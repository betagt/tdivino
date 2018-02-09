<?php

namespace Modules\Transporte\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Repositories\UserRepositoryEloquent;
use Modules\Transporte\Criteria\TipoDocumentoCriteria;
use Modules\Transporte\Http\Requests\ServicoRequest;
use Modules\Transporte\Models\TipoDocumento;
use Modules\Transporte\Repositories\TipoDocumentoRepository;
use Portal\Http\Controllers\BaseController;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Regras de Acesso - Backend
 *
 * Essa API é responsável pelo gerenciamento de regras de Usuários no portal qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class TipoDocumentoController extends BaseController
{

    /**
     * @var HabilidadeRepository
     */
    private $tipoDocumentoRepository;
    /**
     * @var UserRepositoryEloquent
     */
    private $userRepositoryEloquent;

    public function __construct(
        TipoDocumentoRepository $tipoDocumentoRepository,
        UserRepositoryEloquent $userRepositoryEloquent)
    {
        parent::__construct($tipoDocumentoRepository, TipoDocumentoCriteria::class);
        $this->tipoDocumentoRepository = $tipoDocumentoRepository;
        $this->userRepositoryEloquent = $userRepositoryEloquent;
    }


    public function getValidator($id = null)
    {
        $this->validator = (new ServicoRequest())->rules($id);
        return $this->validator;
    }


    public function todos(){
        dd($this->userRepositoryEloquent->documentosPententes(214));
        try{
            return $this->tipoDocumentoRepository->all();
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

    public function pessoa(){
        try{
            return $this->tipoDocumentoRepository->findWhere(['tipo'=>TipoDocumento::TIPO_PESSOA]);
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

    public function veiculo(){
        try{
            return $this->tipoDocumentoRepository->findWhere(['tipo'=>'veiculo']);
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
